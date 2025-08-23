<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Bases\Statut;
use Illuminate\Http\Request;

use App\Http\Controllers\Bases\RessourceController;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    public $path = '/assets/images/categories/';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Auth::user()->Categories;
        return view('dashboard.pages.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = Categorie::all()->where('user_id', $request->user()->id)->where('categorie_id', null);
        return view('dashboard.pages.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240",
            'designation' => "required|string|unique:categories|max:255",
            'categorie_id' => "nullable|exists:categories,id",
            'tag' => "max:4294967296",
            'parametre' => "max:4294967296",
            'description' => "max:65535"
        ]);

        $categorie = new Categorie;

        $fields = [
            'designation',
            'categorie_id',
            'description'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $categorie->$field = $request->$field;
            }
        }
        $fields = [
            'tags',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $categorie->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $ressource_controller = app()->make(RessourceController::class);
            $filename = $ressource_controller->store($request->file('image'), $this->path, 500, 500);
            $categorie->image = $filename;
        }

        $categorie->user_id = $request->user()->id;
        $categorie->statut = Statut::ACTIVE;
        $categorie->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categorie = Categorie::findOrFail($id);
        return view('dashboard.pages.categories.view', compact('categorie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);
        $categories = Categorie::all()->where('user_id', $request->user()->id)->where('categorie_id', null);
        return view('dashboard.pages.categories.edit', compact('categorie', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240",
            'designation' => "required|string|unique:categories,designation,$id,id|max:255",
            'categorie_id' => "nullable|exists:categories,id",
            'tag' => "max:4294967296",
            'parametre' => "max:4294967296",
            'description' => "max:65535"
        ]);
        $categorie = Categorie::findOrFail($id);

        $fields = [
            'designation',
            'type',
            // 'email',
            'description'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $categorie->$field = $request->$field;
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
                $categorie->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $ressource_controller = app()->make(RessourceController::class);
            $filename = $ressource_controller->update($this->path . $categorie->image, $request->file('image'), $this->path, 500, 500);
            $categorie->image = $filename;
        }

        $categorie->user_id = $request->user()->id;
        $categorie->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }
}
