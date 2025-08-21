<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Tarif;
use Carbon\Carbon;
use Illuminate\Http\Request;
// use App\Models\OrangeMoney;
use Stripe\Stripe;
use Stripe\Charge;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaiementController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tarif_id' => 'required|string'
        ]);

        try {
            $tarif = Tarif::findOrFail($request->tarif_id);
            $montant = $tarif->prix; 
            //

            $mode_paiement = [
                'methode' => $request->methode,
                'user_id' => $request->user()->id ?? null,
            ];

            switch ($request->methode) {
                case 'orange-money':
                    $mode_paiement['data'] = $this->orange_money($request);
                    break;

                case 'wave':
                    $mode_paiement['data'] = $this->wave($request);
                    break;

                case 'paypal':
                    $mode_paiement['data'] = $this->paypal($request);
                    break;

                case 'credit-card':
                    $amount = intval($montant);
                    $token = $request->stripeToken;
                    $mode_paiement['data'] = $this->credit_card($amount, $token);
                    break;

                default:
                    return back();
                    break;
            }
            

            $abonnement_request = [
                'user_id' => $request->user()->id,
                'tarif_id' => $tarif->id,
                'date_debut' => Carbon::now(),
                'date_fin' => Carbon::now()->addDays($tarif->duree)
            ];

            $abonnement_request = new Request($abonnement_request);
            $abonnement_controller = app()->make(AbonnementController::class);
            $abonnement = $abonnement_controller->store($abonnement_request);
            $paiement = new Paiement;
            
            $request->user()->assignRole($tarif->roles);
            $request->user()->givePermissionTo($tarif->permissions);
            $paiement->montant = $montant;
            $paiement->mode_paiement = json_encode($mode_paiement);
            $paiement->etat = True;
            $paiement->abonnement_id = $abonnement->id;
            $paiement->save();
            return redirect()->route('dashboard')->with('success', 'Paiement réussi !');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Paiement $paiement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paiement $paiement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paiement $paiement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paiement $paiement)
    {
        //
    }

    public function mode_paiement($id)
    {
        $tarif = Tarif::findOrFail($id);
        return view('pages.paiements.index', compact('tarif'));
    }
    public function paiement(Request $request)
    {
        $tarif = Tarif::findOrFail($request->tarif_id);
        $methode = $request->methode;
        switch ($methode) {
            case 'orange-money':
                return view('pages.paiements.orange-money', compact('tarif', 'methode'));
                break;

            case 'wave':
                return view('pages.paiements.wave', compact('tarif', 'methode'));
                break;

            case 'paypal':
                return view('pages.paiements.paypal', compact('tarif', 'methode'));
                break;

            case 'credit-card':
                return view('pages.paiements.stripe', compact('tarif', 'methode'));
                break;

            default:
                return back();
                break;
        }

        // return view('pages.paiements.view', compact('tarif', 'methode'));
    }

    private function orange_money(Request $request)
    {

        return;
    }
    private function wave(Request $request)
    {
        return 'success';
    }

    private function paypal(Request $request)  
    // private function paypal_success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('services.paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->query('token'));

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            return redirect()->route('dashboard')->with('success', 'Paiement réussi via PayPal.');
        }

        return redirect()->route('dashboard')->with('error', 'Le paiement PayPal a échoué.');
    }

    private function paypal_cancel()
    {
        return redirect()->route('dashboard')->with('error', 'Le paiement a été annulé.');
    }

    private function credit_card($amount, $token, $currency = 'xof', $description = 'Paiement pour votre abonnement')
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => $amount,
                'currency' => $currency,
                'source' => $token,
                'description' => $description,
            ]);

            return $charge;
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}





