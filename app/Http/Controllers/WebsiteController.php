<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use App\Models\Bases\Ressource;

class WebsiteController extends Controller
{
    public $path = '/assets/images/websites/';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $websites = Website::where('user_id', $request->user()->id)->get();
        return view('dashboard.pages.websites.index', compact('websites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.websites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:websites,slug',
        ]);

        $website = new Website;

        // Champs simples
        $fields = [
            'designation',
            'slug',
            'theme',
            'type',
            'description',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $website->$field = $request->$field;
            }
        }

        // Champs JSON
        $fields = [
            'sections',
            'telephones',
            'reseaux_sociaux',
            'parametre',
            'adresse',
            'tags',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $website->$field = json_encode($request->$field);
            }
        }

        // Gestion logo
        if ($request->hasFile('logo')) {
            $ressource = Ressource::file($request->file('logo'));
            $website->logo = $ressource->uploadImage($this->path, width: 500);
        }

        // Gestion favicon
        if ($request->hasFile('favicon')) {
            $ressource = Ressource::file($request->file('favicon'));
            $website->favicon = $ressource->uploadImage($this->path, width: 128);
        }

        $website->user_id = $request->user()->id;
        $website->save();

        return redirect()->route('websites.edit', $website->id)->with('success', 'Site créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $website = Website::findOrFail($id);
        return view('dashboard.pages.websites.view', compact('website'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $website = Website::findOrFail($id);
        return view('dashboard.pages.websites.edit', compact('website'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $website = Website::findOrFail($id);

        $request->validate([
            'designation' => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:websites,slug,' . $id . ',id',
        ]);

        // Champs simples
        $fields = [
            'designation',
            'slug',
            'theme',
            'type',
            'description',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $website->$field = $request->$field;
            }
        }

        // Champs JSON
        $fields = [
            'sections',
            'telephones',
            'reseaux_sociaux',
            'parametre',
            'adresse',
            'tags',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $website->$field = json_encode($request->$field);
            }
        }

        // Gestion logo
        if ($request->hasFile('logo')) {
            $ressource = Ressource::file($request->file('logo'));
            $website->logo = $ressource->updateImage($this->path . $website->logo, $this->path, 500);
        }

        // Gestion favicon
        if ($request->hasFile('favicon')) {
            $ressource = Ressource::file($request->file('favicon'));
            $website->favicon = $ressource->updateImage($this->path . $website->favicon, $this->path, 128);
        }

        $website->update();

        return back()->with('success', 'Site modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $website = Website::findOrFail($id);
        $website->delete();
        return back()->with('success', 'Site supprimé avec succès.');
    }
}
