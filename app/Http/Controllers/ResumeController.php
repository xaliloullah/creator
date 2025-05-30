<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use App\Models\Bases\Ressource;

class ResumeController extends Controller
{
    public $path = '/assets/images/resumes/';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $resumes = Resume::where('user_id', $request->user()->id)->get();
        return view('dashboard.modules.resumes.index', compact('resumes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.modules.resumes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'prenom' => 'required|string',
            'email' => 'nullable|email|max:255',
        ]);

        $resume = new Resume;
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
                $resume->$field = $request->$field;
            }
        }
        $fields = [
            'telephones',
            'permis',
            'adresse'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $resume->$field = json_encode($request->$field);
            }
        }
        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $resume->image = $ressource->uploadImage($this->path, width: 500);
        }
        $resume->user_id = $request->user()->id;
        $resume->save();
        return redirect()->route('resumes.edit', $resume->id)->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resume = Resume::findOrFail($id);
        return view('dashboard.modules.resumes.view', compact('resume'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $resume = Resume::findOrFail($id);
        return view('dashboard.modules.resumes.edit', compact('resume'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'prenom' => 'required|string',
            'email' => 'nullable|email|max:255',
        ]);
        $resume = Resume::findOrFail($id);

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
                $resume->$field = $request->$field;
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
                $resume->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $resume->image = $ressource->updateImage($this->path . $resume->image, $this->path, 500);
        }
        $resume->user_id = $request->user()->id;
        $resume->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $resume = Resume::findOrFail($id);
        $resume->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }
}
