<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;

use App\Models\RH\Employe;
use App\Models\RH\Poste;
use App\Models\Bases\Ressource;
use App\Models\Bases\Statut;

// use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    public $path = '/assets/images/employes/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employes = Employe::all();
        return view('dashboard.modules.employes.index', compact('employes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $postes = Poste::all();
        $statuts = Statut::forState();
        return view('dashboard.modules.employes.create', compact('postes', 'statuts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            'prenom' => 'required|string|max:255',
            'nom' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:employes',
            'telephone' => 'nullable|string|unique:employes',
            'lieu_naissance' => 'nullable|string',
            'civilite' => 'nullable|string',
            'site_web' => 'nullable|string',
            'reseaux_sociaux' => 'nullable|string',
            'description' => 'nullable|string',
            'ip' => 'nullable|string|unique:employes',
            'statut' => 'nullable|string',
            'parametre' => "max:65535",
            
            // 'telephones' => "json|max:4294967296",
            // 'tags' => 'nullable|string',
            // 'adresse' => "json|max:4294967296",
        ]);

        $employe = new Employe;

        $fields = [
            'prenom',
            'nom',
            'email',
            'telephone',
            'sexe',
            'lieu_naissance',
            'civilite',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $employe->$field = $request->$field;
            }
        }
        $fields = [
            // 'telephones',
            'adresse',
            'reseaux_sociaux',
            'site_web'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $employe->$field = json_encode($request->$field);
            }
        }
        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $employe->image = $ressource->uploadImage($this->path, width: 500);
        }
        $employe->user_id = $request->user()->id;
        $employe->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employe = Employe::findOrFail($id);
        return view('dashboard.modules.employes.view', compact('employe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employe = Employe::findOrFail($id);
        $postes = Poste::all();
        $statuts = Statut::forState();
        return view('dashboard.modules.employes.edit', compact('employe', 'postes', 'statuts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            'prenom' => 'required|string|max:255',
            'nom' => 'nullable|string|max:255',
            'email' => "nullable|email|unique:employes,email,$id",
            'telephone' => "nullable|string|unique:employes,telephone,$id",
            'lieu_naissance' => 'nullable|string',
            'civilite' => 'nullable|string',
            'site_web' => 'nullable|string',
            'reseaux_sociaux' => 'nullable|string',
            'description' => 'nullable|string',
            'ip' => "nullable|string|unique:employes,ip,$id",
            'statut' => 'nullable|string',
            'parametre' => "max:65535",

            // 'telephones' => "json|max:4294967296",
            // 'tags' => 'nullable|string',
            // 'adresse' => "json|max:4294967296",
        ]);
        $employe = Employe::where('id', $id)->first();
        $fields = [
            'prenom',
            'nom',
            'email',
            'telephone',
            'sexe',
            'lieu_naissance',
            'civilite',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $employe->$field = $request->$field;
            }
        }
        $fields = [
            // 'telephones',
            'adresse',
            'reseaux_sociaux',
            'site_web'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $employe->$field = json_encode($request->$field);
            }
        }
        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $employe->image = $ressource->updateImage($this->path . $employe->image, $this->path, 500);
        }
        $employe->user_id = $request->user()->id;
        $employe->update();
        return back()->with('success', 'Modification effectué avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employe = Employe::findOrFail($id);
        $ressource = Ressource::file($this->path . $employe->image);
        $employe->delete();
        $ressource->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $mode = $request->input('mode');
        if ($query != '') {
            $employes = Employe::where('user_id', $request->user()->id)
                ->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('email', 'like', '%' . $query . '%')
                        ->orWhere('prenom', 'like', '%' . $query . '%')
                        ->orWhere('nom', 'like', '%' . $query . '%')
                        ->orWhere('sexe', 'like', '%' . $query . '%')
                        ->orWhereJsonContains('telephones', $query);
                })->get();
            return view('dashboard.modules.employes.search', compact('employes', 'mode'));
        }
    }
}
