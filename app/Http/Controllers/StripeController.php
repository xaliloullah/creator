<?php

namespace App\Http\Controllers;

use Stripe\Stripe;

class StripeController
{
    public function getStripeData($paymentIntentId)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
            return response()->json(['paymentIntent' => $paymentIntent]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
