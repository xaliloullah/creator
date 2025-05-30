<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Extends\Statut;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public $path = '/assets/images/menus/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
        return view('dashboard.modules.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuts = Statut::forState();
        return view('dashboard.modules.menus.create', compact('statuts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required|string|unique:menus',
            'image' => 'mimes:png,jpg,jpeg,bmp,webp',
            'description' => 'max:65535',
        ]);
        $menu = new Menu;
        $fields = [
            'designation',
            'description',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $menu->$field = $request->$field;
            }
        }
        $fields = [
            'parametre',
            'tags',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $menu->$field = json_encode($request->$field);
            }
        }
        if ($request->hasfile('image')) {
            $ressource_controller = app()->make(RessourceController::class);
            $filename = $ressource_controller->store($request->file('image'), $this->path, 500, 500);
            $menu->image = $filename;
        }
        $menu->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return view('dashboard.modules.menus.view', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $statuts = Statut::forState();
        return view('dashboard.modules.menus.edit', compact('menu', 'statuts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => "required|string|unique:menus,designation,$id,id",
            'image' => 'mimes:png,jpg,jpeg,bmp,webp',
            'description' => 'max:65535',
        ]);
        $menu = Menu::where('id', $id)->first();
        $fields = [
            'designation',
            'description',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $menu->$field = $request->$field;
            }
        }
        $fields = [
            'parametre',
            'tags',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $menu->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $ressource_controller = app()->make(RessourceController::class);
            $ressource_controller->destroy(
                $this->path . ($menu->image ?? 'default.png')
            );
            $filename = $ressource_controller->store($request->file('image'), $this->path, 500, 500);
            $menu->image = $filename;
        }
        $menu->update();
        return back()->with('success', 'Modification effectué avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $ressource_controller = app()->make(RessourceController::class);
        $ressource_controller->destroy($this->path . $menu->image);
        $menu->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }
}
