<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contrat;
use Illuminate\Http\Request;
use App\Http\Controllers\Bases\RessourceController;
class ContratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contrats = Contrat::all();
        return view('dashboard.pages.contrats.index', compact('contrats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all()->where('etat', true);
        return view('dashboard.pages.contrats.create', compact('clients'));
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
            'client_id',
            'designation',
            'date',
            'lieu',
        ];
        $contrat = new Contrat;
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $contrat->$field = $request->$field;
            }
        }
        $fields = [
            'articles',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $contrat->$field = json_encode($request->$field);
            }
        }
        $contrat->user_id = $request->user()->id;
        $contrat->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contrat = Contrat::findOrFail(decrypter($id));
        return view('dashboard.pages.contrats.view', compact('contrat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contrat = Contrat::findOrFail($id);
        $clients = Client::all()->where('etat', true);
        return view('dashboard.pages.contrats.edit', compact('contrat', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|string',
        ]);
        $contrat = Contrat::where('id', $id)->first();
        $fields = [
            'client_id',
            'designation',
            'date',
            'lieu',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $contrat->$field = $request->$field;
            }
        }
        $fields = [
            'articles',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $contrat->$field = json_encode($request->$field);
            }
        }
        if ($request->hasfile('image')) {

            $path = '/app/public/images/signatures/';
            $ressource_controller = app()->make(RessourceController::class);
            $filename = $ressource_controller->store($request->file('image'), $path, 600, 300);

            $signature = json_decode($contrat->signature, true);
            $signature['image'] = $filename;
            $signature['date'] = now();
            $signature['ip'] = $request->ip();
            $signature['client'] = $request->userAgent();
            $contrat->signature = json_encode($signature);
        }
        $contrat->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contrat = Contrat::findOrFail($id);
        $contrat->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }

    public function archive($id)
    {
        $contrat = Contrat::findOrFail($id);
        if ($contrat->archive == true) {
            $contrat->archive = false;
            $alert = 'success';
            $message = 'Désarchivivage effectué avec succès.';
        } else {
            $contrat->archive = true;
            $alert = 'warning';
            $message = 'Archivivage effectué avec succès.';
        }
        $contrat->update();
        return back()->with($alert, $message);
    }
    public function etat($id)
    {
        $contrat = Contrat::findOrFail($id);
        if ($contrat->etat == true) {
            $contrat->etat = false;
            $alert = 'warning';
            $message = 'Désactivé.';
        } else {
            $contrat->etat = true;
            $alert = 'success';
            $message = 'Activé.';
        }
        $contrat->update();
        return back()->with($alert, $message);
    }

    public function statut($id)
    {
        $contrat = Contrat::findOrFail($id);
        if ($contrat->statut == true) {
            $contrat->statut = false;
            $alert = 'warning';
            $message = 'Payement annuler.';
        } else {
            $contrat->statut = true;
            $alert = 'success';
            $message = 'Pyement effectuer avec success.';
        }
        $contrat->update();
        return back()->with($alert, $message);
    }
}
