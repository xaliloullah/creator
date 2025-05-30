<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;


use App\Models\RH\Poste;
use App\Models\Bases\Ressource;
use App\Models\Bases\Statut;

use Illuminate\Http\Request;

class PosteController extends Controller
{
    public $path = '/assets/images/postes/';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $postes = Poste::all();
        return view('dashboard.modules.postes.index', compact('postes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuts = Statut::forState();
        return view('dashboard.modules.postes.create', compact('statuts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required|string',
            'salaire' => 'nullable|max:255',
        ]);

        $poste = new Poste;
        $fields = [
            'designation',
            'salaire',
            'statut',
            'description'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $poste->$field = $request->$field;
            }
        }
        $fields = [
            'parametres',
            'tags'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $poste->$field = json_encode($request->$field);
            }
        }
        // if ($request->hasfile('image')) {
        //     $ressource = Ressource::file($request->file('image'));
        //     $poste->image = $ressource->uploadImage($this->path, width: 500);
        // }
        // $poste->user_id = $request->user()->id;
        $poste->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $poste = Poste::findOrFail($id);
        return view('dashboard.modules.postes.view', compact('poste'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $poste = Poste::findOrFail($id);
        $statuts = Statut::forState();
        return view('dashboard.modules.postes.edit', compact('poste', 'statuts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => 'required|string',
            'salaire' => 'nullable|max:255',
        ]);
        $poste = Poste::findOrFail($id);

        $fields = [
            'designation',
            'salaire',
            'statut',
            'description'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $poste->$field = $request->$field;
            }
        }
        $fields = [
            'parametre',
            'tags'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $poste->$field = json_encode($request->$field);
            }
        }
        // $poste->user_id = $request->user()->id;
        $poste->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $poste = Poste::findOrFail($id);
        $poste->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }
}
