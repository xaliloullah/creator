<?php

namespace App\Http\Controllers;


use App\Models\Abonnement;
use Illuminate\Http\Request;


class AbonnementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abonnements = Abonnement::all();
        return view('admin.modules.abonnements.index', compact('abonnements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.modules.abonnements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $model = false)
    {
        $request->validate([
            'user_id' => 'required',
            'tarif_id' => 'required',
            'date_debut' => 'required',
            'date_fin' => 'required'

        ]);
        $abonnement = new Abonnement;
        $fields = [
            'user_id',
            'tarif_id',
            'date_debut',
            'date_fin',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $abonnement->$field = $request->$field;
            }
        }
        $abonnement->etat = True;

        $abonnement->save();
        if ($model) {
            return $abonnement;
        }
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $abonnement = Abonnement::findOrFail($id);
        return view('admin.modules.abonnements.view', compact('abonnement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $abonnement = Abonnement::findOrFail($id);
        return view('admin.modules.abonnements.edit', compact('abonnement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $model = false)
    {
        $request->validate([
            'user_id' => 'required|string:abonnements',
            'tarif_id' => 'required|string',
        ]);
        $abonnement = Abonnement::where('id', $id)->first();
        $fields = [
            'user_id',
            'tarif_id',
            'date_debut',
            'date_fin',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $abonnement->$field = $request->$field;
            }
        }
        $abonnement->update();
        if ($model) {
            return $abonnement;
        }
        return back()->with('success', 'Modification effectué avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $abonnement = Abonnement::findOrFail($id);
        $path = '/assets/images/abonnements/';


        $abonnement->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }
}
