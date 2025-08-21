<?php namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Webhook as StripeWebhook;
use Stripe\Exception\SignatureVerificationException;

class PaymentController extends Controller
{
    /* ---- Init payment (client choisit provider) ---- */
    public function create(Request $req)
    {
        $data = $req->validate([
            'amount' => 'required|numeric|min:0.1',
            'currency' => 'sometimes|string',
            'provider' => 'required|string|in:stripe,wave,orange',
            'order_id' => 'nullable|integer',
            'customer_phone' => 'nullable|string',
            'customer_email' => 'nullable|email',
        ]);

        $amount = $data['amount'];
        $currency = $data['currency'] ?? 'XOF';
        $provider = $data['provider'];

        // create pending record
        $payment = Payment::create([
            'provider' => $provider,
            'status' => 'pending',
            'amount' => $amount,
            'currency' => $currency,
            'order_id' => $data['order_id'] ?? null,
            'meta' => ['initiated_at' => now()->toIso8601String()]
        ]);

        if ($provider === 'stripe') {
            return $this->createStripeSession($payment, $data);
        } elseif ($provider === 'wave') {
            return $this->createWaveCheckout($payment, $data);
        } elseif ($provider === 'orange') {
            return $this->createOrangePayment($payment, $data);
        }

        return response()->json(['error' => 'Unsupported provider'], 400);
    }

    /* ---------------- Stripe: Checkout Session (card) ---------------- */
    protected function createStripeSession(Payment $payment, $data)
    {
        Stripe::setApiKey(config('services.stripe.secret') ?? env('STRIPE_SECRET'));

        $successUrl = env('APP_URL') . "/payments/success?session_id={CHECKOUT_SESSION_ID}";
        $cancelUrl = env('APP_URL') . "/payments/cancel";

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => $payment->currency,
                    'product_data' => ['name' => 'Order #' . ($payment->order_id ?? $payment->id)],
                    'unit_amount' => intval($payment->amount * 100)
                ],
                'quantity' => 1
            ]],
            'metadata' => [
                'payment_id' => $payment->id
            ],
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);

        // store provider payment id
        $payment->update(['provider_payment_id' => $session->id, 'meta->checkout_url' => $session->url]);

        return response()->json(['checkout_url' => $session->url, 'session_id' => $session->id]);
    }

    /* ---------------- Wave: Checkout API (mobile money) ---------------- */
    protected function createWaveCheckout(Payment $payment, $data)
    {
        // Wave requires you to have a business account and API key.
        $client = new Client();
        $apiKey = env('WAVE_API_KEY');
        $base = env('WAVE_BASE_URL', 'https://api.wave.com');

        // Build checkout request — adapt to Wave's official fields
        $payload = [
            'amount' => intval($payment->amount * 100), // sometimes in cents
            'currency' => $payment->currency,
            'merchant_reference' => 'order_'.$payment->id .'_'. Str::random(6),
            'callback_url' => env('APP_URL').'/webhook/wave',
            'description' => 'Paiement commande #' . ($payment->order_id ?? $payment->id),
            // optionally customer mobile
            'customer' => [
                'phone' => $data['customer_phone'] ?? null,
                'email' => $data['customer_email'] ?? null
            ]
        ];

        $res = $client->post($base . '/v1/checkout/sessions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Accept' => 'application/json'
            ],
            'json' => $payload,
            'timeout' => 10
        ]);

        $body = json_decode((string)$res->getBody(), true);

        // store provider payment id & response
        $payment->update([
            'provider_payment_id' => $body['id'] ?? null,
            'meta' => array_merge($payment->meta ?? [], ['wave' => $body])
        ]);

        // return checkout_url to client
        return response()->json(['checkout_url' => $body['url'] ?? ($body['checkout_url'] ?? null), 'raw' => $body]);
    }

    /* ---------------- Orange Money: Business API initiation ---------------- */
    protected function createOrangePayment(Payment $payment, $data)
    {
        // Orange Money Business uses OAuth2 token + specific endpoints (varies by country).
        $client = new Client();
        $base = env('ORANGE_BASE_URL', 'https://api.orange.com');
        $clientId = env('ORANGE_CLIENT_ID');
        $clientSecret = env('ORANGE_CLIENT_SECRET');

        // 1) Get access token (OAuth2 client_credentials)
        $tokenRes = $client->post($base . '/oauth/v3/token', [
            'auth' => [$clientId, $clientSecret],
            'form_params' => ['grant_type' => 'client_credentials'],
            'headers' => ['Accept' => 'application/json'],
        ]);
        $token = json_decode((string)$tokenRes->getBody(), true)['access_token'] ?? null;

        // 2) Initiate payment (merchant payment / webpay endpoint — adapte selon la doc Orange pour ton pays)
        $payload = [
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'merchant_transaction_id' => 'om_'.$payment->id.'_' . Str::random(6),
            'callback_url' => env('APP_URL') . '/webhook/orange',
            'description' => 'Paiement commande #' . ($payment->order_id ?? $payment->id)
        ];

        $res = $client->post($base . '/om/v1/payments', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
            'json' => $payload
        ]);

        $body = json_decode((string)$res->getBody(), true);

        $payment->update([
            'provider_payment_id' => $body['payment_id'] ?? ($body['id'] ?? null),
            'meta' => array_merge($payment->meta ?? [], ['orange' => $body])
        ]);

        // Some Orange flows return a redirect URL for the user to confirm payment on mobile/web
        return response()->json(['raw' => $body, 'message' => 'Orange payment initiated']);
    }

    /* ---------------- Stripe webhook handler ---------------- */
    public function webhookStripe(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = StripeWebhook::constructEvent($payload, $sigHeader, $endpoint_secret);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // handle event types
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $paymentId = $session->metadata->payment_id ?? null;
            if ($paymentId) {
                $payment = Payment::find($paymentId);
                if ($payment) {
                    $payment->update([
                        'status' => 'succeeded',
                        'meta' => array_merge($payment->meta ?? [], ['stripe_event' => $session])
                    ]);
                }
            }
        } elseif ($event->type === 'payment_intent.payment_failed') {
            // ...
        }

        return response()->json(['received' => true]);
    }

    /* ---------------- Wave webhook ---------------- */
    public function webhookWave(Request $request)
    {
        // Wave sends JSON — validate signature if provided by Wave docs
        $payload = $request->all();

        // Locate payment by provider_payment_id or merchant_reference
        $providerId = $payload['id'] ?? $payload['checkout_id'] ?? ($payload['merchant_reference'] ?? null);
        if ($providerId) {
            $payment = Payment::where('provider', 'wave')
                              ->where(function($q) use ($providerId) {
                                  $q->where('provider_payment_id', $providerId)
                                    ->orWhere('meta->merchant_reference', $providerId);
                              })->first();
            if ($payment) {
                $status = $payload['status'] ?? 'unknown';
                $payment->update([
                    'status' => $status === 'succeeded' ? 'succeeded' : ($status === 'failed' ? 'failed' : $payment->status),
                    'meta' => array_merge($payment->meta ?? [], ['wave_webhook' => $payload])
                ]);
            }
        }

        return response()->json(['ok' => true]);
    }

    /* ---------------- Orange webhook ---------------- */
    public function webhookOrange(Request $request)
    {
        // Orange webhook handling — verify signature per Orange doc (depends on country)
        $payload = $request->all();
        $providerId = $payload['payment_id'] ?? $payload['merchant_transaction_id'] ?? null;

        if ($providerId) {
            $payment = Payment::where('provider', 'orange')
                              ->where('provider_payment_id', $providerId)
                              ->first();
            if ($payment) {
                $status = $payload['status'] ?? 'unknown';
                $payment->update([
                    'status' => $status === 'SUCCESS' ? 'succeeded' : ($status === 'FAILED' ? 'failed' : $payment->status),
                    'meta' => array_merge($payment->meta ?? [], ['orange_webhook' => $payload])
                ]);
            }
        }

        return response()->json(['ok' => true]);
    }
}
