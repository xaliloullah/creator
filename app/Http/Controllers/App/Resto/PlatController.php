<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use App\Models\Menu;
use App\Models\Extends\Statut;
use Illuminate\Http\Request;


class PlatController extends Controller
{
    public $path = '/assets/images/plats/';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plats = Plat::all();
        return view('dashboard.modules.plats.index', compact('plats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::all();
        $statuts = Statut::forState();
        return view('dashboard.modules.plats.create', compact('menus', 'statuts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required|string|unique:plats,designation',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,bmp,webp|max:2048',
            'menu_id' => 'required|exists:menus,id|uuid',
            'prix' => 'required|numeric|min:0|max:99999999.99',
            'duree' => 'nullable|integer|min:1',
            'notes' => 'integer|min:0|max:5',
            'reduction' => 'nullable|integer|min:0|max:100',
            'description' => 'max:65535',                            
        ]);
        $plat = new Plat;
        $fields = [
            'designation',
            'menu_id',
            'prix',
            'duree',
            'notes',
            'reduction',
            'description',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $plat->$field = $request->$field;
            }
        }
        $fields = [
            'parametre',
            'tags',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $plat->$field = json_encode($request->$field);
            }
        }
        if ($request->hasfile('image')) {
            $ressource_controller = app()->make(RessourceController::class);
            $filename = $ressource_controller->store($request->file('image'), $this->path, 500, 500);
            $plat->image = $filename;
        }
        $plat->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $plat = Plat::findOrFail($id);
        return view('dashboard.modules.plats.view', compact('plat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $plat = Plat::findOrFail($id);
        $menus = Menu::all();
        $statuts = Statut::forState();
        return view('dashboard.modules.plats.edit', compact('plat', 'menus', 'statuts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => "required|string|unique:plats,designation,$id,id",
            'image' => 'nullable|image|mimes:png,jpg,jpeg,bmp,webp|max:2048',
            'description' => 'max:65535',
            'menu_id' => 'required|exists:menus,id|uuid',
            'prix' => 'required|numeric|min:0|max:99999999.99',
            'duree' => 'nullable|integer|min:1',
            'notes' => 'integer|min:0|max:5',
            'reduction' => 'nullable|integer|min:0|max:100',
        ]);
        $plat = Plat::where('id', $id)->first();
        $fields = [
            'designation',
            'menu_id',
            'prix',
            'duree',
            'notes',
            'reduction',
            'description',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $plat->$field = $request->$field;
            }
        }
        $fields = [
            'parametre',
            'tags',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $plat->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $ressource_controller = app()->make(RessourceController::class);
            $ressource_controller->destroy(
                $this->path . ($plat->image ?? 'default.png')
            );
            $filename = $ressource_controller->store($request->file('image'), $this->path, 500, 500);
            $plat->image = $filename;
        }
        $plat->update();
        return back()->with('success', 'Modification effectué avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $plat = Plat::findOrFail($id);
        $ressource_controller = app()->make(RessourceController::class);
        $ressource_controller->destroy($this->path . $plat->image);
        $plat->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }
}
