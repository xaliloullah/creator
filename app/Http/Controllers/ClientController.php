<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bases\Ressource;
use App\Models\Bases\Statut;

class ClientController extends Controller
{
    public $path = '/assets/images/clients/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Auth::user()->Clients;
        return view('dashboard.modules.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuts = Statut::forState();
        return view('dashboard.modules.clients.create', compact('statuts'));
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
            'email' => 'nullable|email|unique:clients',
            'telephone' => 'nullable|string|unique:clients',
            'fonction' => 'nullable|string',
            'civilite' => 'nullable|string',
            'site_web' => 'nullable|string',
            'reseaux_sociaux' => 'nullable|string',
            'description' => 'nullable|string',
            'ip' => 'nullable|string|unique:clients',
            'statut' => 'nullable|string',
            // 'adresse' => "json|max:4294967296",
            'parametre' => "json|max:4294967296",
            // 'telephones' => "json|max:4294967296",
            // 'tags' => 'nullable|string',
        ]);

        $client = new Client;

        $fields = [
            'prenom',
            'nom',
            'email',
            'telephone',
            'entreprise',
            'fonction',
            'civilite',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $client->$field = $request->$field;
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
                $client->$field = json_encode($request->$field);
            }
        }
        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $client->image = $ressource->uploadImage($this->path, width: 500);
        }
        $client->user_id = $request->user()->id;
        $client->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('dashboard.modules.clients.view', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $statuts = Statut::forState();
        return view('dashboard.modules.clients.edit', compact('client', 'statuts'));
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
            'email' => "nullable|email|unique:clients,email,$id",
            'telephone' => "nullable|string|unique:clients,telephone,$id",
            'fonction' => 'nullable|string',
            'civilite' => 'nullable|string',
            'site_web' => 'nullable|string',
            'reseaux_sociaux' => 'nullable|string',
            'description' => 'nullable|string',
            'ip' => "nullable|string|unique:clients,ip,$id",
            'statut' => 'nullable|string',
            // 'adresse' => "json|max:4294967296",
            'parametre' => "json|max:4294967296",
            // 'telephones' => "json|max:4294967296",
            // 'tags' => 'nullable|string',
        ]);
        $client = Client::where('id', $id)->first();
        $fields = [
            'prenom',
            'nom',
            'email',
            'telephone',
            'entreprise',
            'fonction',
            'civilite',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $client->$field = $request->$field;
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
                $client->$field = json_encode($request->$field);
            }
        }
        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $client->image = $ressource->updateImage($this->path . $client->image, $this->path, 500);
        }
        $client->user_id = $request->user()->id;
        $client->update();
        return back()->with('success', 'Modification effectué avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $ressource = Ressource::file($this->path . $client->image);
        $client->delete();
        $ressource->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $mode = $request->input('mode');
        if ($query != '') {
            $clients = Client::where('user_id', $request->user()->id)
                ->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('email', 'like', '%' . $query . '%')
                        ->orWhere('prenom', 'like', '%' . $query . '%')
                        ->orWhere('nom', 'like', '%' . $query . '%')
                        ->orWhere('entreprise', 'like', '%' . $query . '%')
                        ->orWhereJsonContains('telephones', $query);
                })->get();
            return view('dashboard.modules.clients.search', compact('clients', 'mode'));
        }
    }
}
