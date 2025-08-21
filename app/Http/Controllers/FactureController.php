<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $factures = Auth::user()->Factures;
        return view('dashboard.modules.factures.index', compact('factures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        $produits = Produit::all();
        return view('dashboard.modules.factures.create', compact('clients', 'produits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'client_id' => 'required|string',
            'description' => 'max:65535',
            'tag' => 'max:65535',
        ]);

        $fields = [
            'user_id',
            'client_id',
            'designation',
            'date_emission',
            'date_echeance',
            'conditions',
            'tva',
        ];

        $facture = new Facture;
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $facture->$field = $request->$field;
            }
        }

        $fields = [
            'articles',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $facture->$field = json_encode($request->$field);
            }
        }
        $facture->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $facture = Facture::findOrFail(decrypter($id));
        // $facture->parametre = json_decode($facture->parametre ?? '{}', true);
        // $facture->articles = json_decode($facture->articles ?? '{}', true);
        return view('dashboard.modules.factures.view', compact('facture'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $facture = Facture::findOrFail($id);
        $clients = Client::all();
        return view('dashboard.modules.factures.edit', compact('facture', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|string',
            'client_id' => 'required|string',
        ]);
        $fields = [
            'user_id',
            'client_id',
            'designation',
            'date_emission',
            'date_echeance',
            'conditions',
            'tva',
            'devise'
        ];
        $facture = Facture::where('id', $id)->first();
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $facture->$field = $request->$field;
            }
        }

        $fields = [
            'articles',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $facture->$field = json_encode($request->$field);
            }
        }
        $facture->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $facture = Facture::findOrFail($id);
        $facture->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }

    // public function archive($id)
    // {
    //     $facture = Facture::findOrFail($id);
    //     if ($facture->archive == true) {
    //         $facture->archive = false;
    //         $alert = 'success';
    //         $message = 'Désarchivage effectué avec succès.';
    //     } else {
    //         $facture->archive = true;
    //         $alert = 'warning';
    //         $message = 'Archivage effectué avec succès.';
    //     }
    //     $facture->update();
    //     return back()->with($alert, $message);
    // }

    // public function etat($id)
    // {
    //     $facture = Facture::findOrFail($id);
    //     if ($facture->etat == true) {
    //         $facture->etat = false;
    //         $alert = 'warning';
    //         $message = 'Désactivé.';
    //     } else {
    //         $facture->etat = true;
    //         $alert = 'success';
    //         $message = 'Activé.';
    //     }
    //     $facture->update();
    //     return back()->with($alert, $message);
    // }

    // public function statut($id)
    // {
    //     $facture = Facture::findOrFail($id);
    //     if ($facture->statut == true) {
    //         $facture->statut = false;
    //         $alert = 'warning';
    //         $message = 'Payement annuler.';
    //     } else {
    //         $facture->statut = true;
    //         $alert = 'success';
    //         $message = 'Pyement effectuer avec success.';
    //     }
    //     $facture->update();
    //     return back()->with($alert, $message);
    // }
}
