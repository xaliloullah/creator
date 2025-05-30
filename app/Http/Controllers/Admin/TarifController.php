<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Tarif;
use App\Models\Bases\Role;
use App\Models\Bases\Permission;
use App\Models\Bases\Statut;
use Illuminate\Http\Request;


class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifs = Tarif::all();
        return view('dashboard.modules.admin.tarifs.index', compact('tarifs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $statuts = Statut::forState();
        return view('dashboard.modules.admin.tarifs.create', compact('roles', 'permissions', 'statuts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'designation' => 'required|string|unique:tarifs',
            'prix' => 'required:tarifs',
            'statut' => 'required:tarifs',
        ]);
        $tarif = new Tarif;
        $fields = [
            'designation',
            'prix',
            'duree',
            'reduction',
            'description',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $tarif->$field = $request->$field;
            }
        }

        $fields = [
            'parametre',
            'roles',
            'permissions',
            'tags',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $tarif->$field = json_encode($request->$field);
            }
        }
        $tarif->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tarif = Tarif::findOrFail($id);
        return view('dashboard.modules.admin.tarifs.view', compact('tarif'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tarif = Tarif::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        $statuts = Statut::forState();
        return view('dashboard.modules.admin.tarifs.edit', compact('tarif', 'roles', 'permissions', 'statuts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => "required|string|unique:tarifs,designation,$id,id",
            'prix' => 'required|string:tarifs',
            'statut' => 'required:tarifs',
        ]);
        $tarif = Tarif::where('id', $id)->first();
        $fields = [
            'designation',
            'prix',
            'duree',
            'reduction',
            'description',
            'statut',

        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $tarif->$field = $request->$field;
            }
        }
        // json
        $fields = [
            'parametre',
            'roles',
            'permissions',
            'tags',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $tarif->$field = json_encode($request->$field);
            }
        }
        $tarif->update();
        return back()->with('success', 'Modification effectué avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tarif = Tarif::findOrFail($id);
        $path = '/app/public/images/tarifs/';
        $tarif->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }

    public function statut(Request $request)
    {
        // $tarif = Tarif::findOrFail($id);
        // if ($tarif->statut == true) {
        //     $tarif->statut = false;
        //     $alert = 'warning';
        //     $message = 'Payement annuler.';
        // } else {
        //     $tarif->statut = true;
        //     $alert = 'success';
        //     $message = 'Pyement effectuer avec success.';
        // }
        // $tarif->update();
        // return back()->with($alert, $message);
    }
}
