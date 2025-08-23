<?php

namespace App\Http\Controllers;

use App\Models\Devi;
use Illuminate\Http\Request;

class DeviController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devis = Devi::all();
        return view('dashboard.pages.devis.index', compact('devis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.devis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|string',
        ]);
        $fields = [
            'designation',
            'client_id',
            'date_emission',
            'date_echeance',
            'conditions',
            'tva',
            'devise'
        ];
        $devi = new Devi;
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $devi->$field = $request->$field;
            }
        }
        $fields = [
            'articles',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $devi->$field = json_encode($request->$field);
            }
        }
        $devi->user_id = $request->user()->id;
        $devi->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $devi = Devi::findOrFail(decrypter($id));
        return view('dashboard.pages.devis.view', compact('devi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $devi = Devi::findOrFail($id);
        return view('dashboard.pages.devis.edit', compact('devi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|string',
        ]);
        $fields = [
            'designation',
            'client_id',
            'date_emission',
            'date_echeance',
            'conditions',
            'tva',
            'devise'
        ];
        $devi = Devi::where('id', $id)->first();
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $devi->$field = $request->$field;
            }
        }
        $fields = [
            'articles',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $devi->$field = json_encode($request->$field);
            }
        }
        $devi->user_id = $request->user()->id;
        $devi->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $devi = Devi::findOrFail($id);
        $devi->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }

    public function archive($id)
    {
        $devi = Devi::findOrFail($id);
        if ($devi->archive == true) {
            $devi->archive = false;
            $alert = 'success';
            $message = 'Désarchivivage effectué avec succès.';
        } else {
            $devi->archive = true;
            $alert = 'warning';
            $message = 'Archivivage effectué avec succès.';
        }
        $devi->update();
        return back()->with($alert, $message);
    }
    public function etat($id)
    {
        $devi = Devi::findOrFail($id);
        if ($devi->etat == true) {
            $devi->etat = false;
            $alert = 'warning';
            $message = 'Désactivé.';
        } else {
            $devi->etat = true;
            $alert = 'success';
            $message = 'Activé.';
        }
        $devi->update();
        return back()->with($alert, $message);
    }

    public function statut($id)
    {
        $devi = Devi::findOrFail($id);
        if ($devi->statut == true) {
            $devi->statut = false;
            $alert = 'warning';
            $message = 'Payement annuler.';
        } else {
            $devi->statut = true;
            $alert = 'success';
            $message = 'Pyement effectuer avec success.';
        }
        $devi->update();
        return back()->with($alert, $message);
    }
}
