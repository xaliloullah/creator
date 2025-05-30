<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;

use Illuminate\Http\Request;
use App\Models\Bases\Ressource;

class ProduitController extends Controller
{
    public $path = '/assets/images/produits/';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produits = Produit::all()->where('user_id', $request->user()->id);
        return view('dashboard.modules.produits.index', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = Categorie::all()->where('user_id', $request->user()->id)->where('categorie_id', null);
        return view('dashboard.modules.produits.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            'designation' => "required|string|unique:produits|max:255",
            'categorie_id' => "nullable|exists:categories,id",
            'tag' => "json|max:4294967296",
            'parametre' => "json|max:4294967296",
            'description' => "max:65535"
        ]);

        $produit = new Produit;

        $fields = [
            'designation',
            'type',
            'description'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $produit->$field = $request->$field;
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
                $produit->$field = json_encode($request->$field);
            }
        }


        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $ressource->setFilename($produit->designation);
            $produit->image = $ressource->uploadImage($this->path, width: 500);
        }

        $produit->user_id = $request->user()->id;
        $produit->save();
        return redirect()->route('produits.edit', $produit->id)->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produit = Produit::findOrFail($id);
        return view('dashboard.modules.produits.view', compact('produit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        return view('dashboard.modules.produits.edit', compact('produit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            'designation' => "required|string|unique:produits,designation,$id,id|max:255",
            'categorie_id' => "nullable|exists:categories,id",
            'tag' => "json|max:4294967296",
            'parametre' => "json|max:4294967296",
            'description' => "max:65535"
        ]);
        $produit = Produit::findOrFail($id);

        $fields = [
            'designation',
            'type',
            'description'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $produit->$field = $request->$field;
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
                $produit->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $ressource->setFilename($produit->designation);
            $produit->image = $ressource->updateImage($this->path . $produit->image, $this->path, 500);
        }

        $produit->user_id = $request->user()->id;
        $produit->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produit = Produit::findOrFail($id);
        $ressource = Ressource::file($this->path . $produit->image);
        $produit->delete();
        $ressource->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }
}
