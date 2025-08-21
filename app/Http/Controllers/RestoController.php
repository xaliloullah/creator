<?php

namespace App\Http\Controllers;

use App\Models\Resto;
use Illuminate\Http\Request;

use App\Models\Bases\Ressource;

class RestoController extends Controller
{
    public $path = '/assets/images/restos/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restos = Resto::all();
        return view('dashboard.modules.restos.index', compact('restos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.modules.restos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'designation' => 'required|string|max:255',
            'type' => 'required|string',
        ]);

        $resto = new Resto;

        $fields = [
            'designation',
            'type',
            // 'email',
            'description'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $resto->$field = $request->$field;
            }
        }
        $fields = [
            'telephones',
            'adresse',
            'site_web',
            'reseaux_sociaux',
            'tags',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $resto->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $resto->image = $ressource->uploadImage($this->path, width: 500);
        }

        $resto->user_id = $request->user()->id;
        $resto->save();
        return redirect()->route('restos.edit', $resto->id)->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resto = Resto::findOrFail($id);
        return view('dashboard.modules.restos.view', compact('resto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $resto = Resto::findOrFail($id);
        return view('dashboard.modules.restos.edit', compact('resto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'designation' => 'required|string|max:255',
            'type' => 'required|string',
            // 'email' => 'nullable|email|max:255',
        ]);
        $resto = Resto::findOrFail($id);

        $fields = [
            'designation',
            'type',
            // 'email',
            'description'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $resto->$field = $request->$field;
            }
        }
        $fields = [
            'telephones',
            'adresse',
            'site_web',
            'reseaux_sociaux',
            'tags',
            'parametre'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $resto->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $ressource->setFilename($resto->designation);
            $resto->image = $ressource->updateImage($this->path . $resto->image, $this->path, 500);
        }

        $resto->user_id = $request->user()->id;
        $resto->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $resto = Resto::findOrFail($id);
        $ressource = Ressource::file($this->path . $resto->image);
        $resto->delete();
        $ressource->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }

    // public function archive($id)
    // {
    //     $resto = Resto::findOrFail($id);
    //     if ($resto->archive == true) {
    //         $resto->archive = false;
    //         $alert = 'success';
    //         $message = 'Désarchivivage effectué avec succès.';
    //     } else {
    //         $resto->archive = true;
    //         $alert = 'warning';
    //         $message = 'Archivivage effectué avec succès.';
    //     }
    //     $resto->save();
    //     return back()->with($alert, $message);
    // } 
}
