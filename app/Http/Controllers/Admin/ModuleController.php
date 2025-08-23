<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bases\Permission;
use App\Models\Module;
use App\Models\Bases\Statut;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Module::all();
        return view('dashboard.pages.admin.modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
        $statuts = Statut::forState();
        $modules = Module::all();
        return view('dashboard.pages.admin.modules.create', compact( 'statuts', 'modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required|string|unique:modules',  
        ]);
        $module = new Module;
        $fields = [
            'name',
            'designation',
            'color',
            'icon', 
            'route',
            'link',
            'lock',
            'hidden',
            'target',
            'module_id',
            'description', 
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $module->$field = $request->$field;
            }
        }

        $fields = [ 
            'tags',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $module->$field = json_encode($request->$field);
            }
        }

        $module->save();
        $permission = new Permission();
        $fields = [
            'name',
            'designation',
            'description'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $permission->$field = $module->$field;
            }
        } 
        $permission->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $module = Module::findOrFail($id);
        return view('dashboard.pages.admin.modules.view', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $module = Module::findOrFail($id); 
        $statuts = Statut::forState();
        $modules = Module::all()->where('id', '!=', $id);
        return view('dashboard.pages.admin.modules.edit', compact('module','statuts', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => "required|string|unique:modules,name,$id,id",  
        ]);
        $module = Module::where('id', $id)->first();
        // $permission = Permission::where('name', $module->name);
        $fields = [
            'name',
            'designation',
            'color',
            'icon', 
            'route',
            'link',
            'lock',
            'hidden',
            'target',
            'module_id',
            'description', 
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $module->$field = $request->$field;
            }
        }
        // json
        $fields = [ 
            'tags',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $module->$field = json_encode($request->$field);
            }
        }
        $module->update();
        // $fields = [
        //     'name',
        //     'designation',
        //     'description'
        // ];
        // foreach ($fields as $field) {
        //     if ($request->has($field)) {
        //         $permission->$field = $module->$field;
        //     }
        // } 
        // $permission->save();
        return back()->with('success', 'Modification effectué avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $path = '/app/public/images/modules/';
        $module->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    } 
}
