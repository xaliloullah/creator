<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $businesses = Business::all();
        return view('dashboard.pages.business.index', compact('businesses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.business.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string',
            'email' => 'required|string',
        ]);
        $fields = [
            'image',
            'prenom',
            'nom',
            'email',
            'titre',
            'date_naissance',
            'lieu_naissance',
            'description'
        ];

        $business = new Business;
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $business->$field = $request->$field;
            }
        }
        $fields = [
            'telephones',
            'permis',
            'adresse'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $business->$field = json_encode($request->$field);
            }
        }
        $business->user_id = $request->user()->id;
        $business->save();
        return redirect()->route('businesses.edit', $business->id)->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $business = Business::findOrFail(decrypter($id));
        return view('dashboard.pages.business.view', compact('business'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $business = Business::findOrFail($id);
        return view('dashboard.pages.business.edit', compact('business'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'prenom' => 'required|string',
            'email' => 'required|string',
        ]);
        $business = Business::where('id', $id)->first();

        $fields = [
            'image',
            'prenom',
            'nom',
            'email',
            'titre',
            'date_naissance',
            'lieu_naissance',
            'description'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $business->$field = $request->$field;
            }
        }
        $fields = [
            'formations',
            'competences',
            'experiences',
            'langues',
            'reseaux_sociaux',
            'interets',
            'telephones',
            'adresse',
            'certifications',
            'projets',
            'permis',
            'liens',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $business->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $path = '/app/public/images/businesses/';
            $ressource_controller = app()->make(RessourceController::class);
            $filename = $ressource_controller->store($request->file('image'), $path, 500, 500);
            $business->image = $filename;
        }
        $business->user_id = $request->user()->id;
        $business->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        $business->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }

    public function archive($id)
    {
        $business = Business::findOrFail(decrypter($id));
        if ($business->archive == true) {
            $business->archive = false;
            $alert = 'success';
            $message = 'Désarchivivage effectué avec succès.';
        } else {
            $business->archive = true;
            $alert = 'warning';
            $message = 'Archivivage effectué avec succès.';
        }
        $business->save();
        return back()->with($alert, $message);
    }
    public function etat($id)
    {
        $business = Business::findOrFail($id);
        if ($business->etat == true) {
            $business->etat = false;
            $alert = 'warning';
            $message = 'Désactivé.';
        } else {
            $business->etat = true;
            $alert = 'success';
            $message = 'Activé.';
        }
        $business->save();
        return back()->with($alert, $message);
    }

    public function statut($id)
    {
        $business = Business::findOrFail($id);
        if ($business->statut == true) {
            $business->statut = false;
            $alert = 'warning';
            $message = 'annuler.';
        } else {
            $business->statut = true;
            $alert = 'success';
            $message = 'success.';
        }
        $business->save();
        return back()->with($alert, $message);
    }
}
