<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Bases\RessourceController;
use App\Models\Bases\Ressource;
use App\Models\User;
use App\Models\Bases\Role;
use App\Models\Bases\Permission;
use App\Models\Bases\Statut;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $path = '/assets/images/users/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('dashboard.modules.admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $statuts = Statut::forUser();
        return view('dashboard.modules.admin.users.create', compact('roles', 'permissions', 'statuts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string:users',
            'email' => 'required|string|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => 'mimes:png,jpg,jpeg,bmp,webp',
            'parametre' => "json|max:4294967296",
        ]);
        $user = new User;
        $fields = [
            'prenom',
            'nom',
            'email',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $user->$field = $request->$field;
            }
        }
        $fields = [
            'parametre',
            'telephones',
            'adresse',
            'tags',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $user->$field = json_encode($request->$field);
            }
        }
        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $user->image = $ressource->uploadImage($this->path, width: 500);
        }
        $user->password = Hash::make($request->password);
        $user->assignRole($request->roles);
        $user->syncPermissions($request->permissions);
        $user->markEmailAsVerified();
        $user->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.modules.admin.users.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        $statuts = Statut::forUser();
        return view('dashboard.modules.admin.users.edit', compact('user', 'roles', 'permissions', 'statuts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'prenom' => 'required|string:users',
            'email' => "required|string|unique:users,email,$id,id",
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'image' => 'mimes:png,jpg,jpeg,bmp,webp',
        ]);
        $user = User::where('id', $id)->first();
        $fields = [
            'prenom',
            'nom',
            'email',
            'statut',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $user->$field = $request->$field;
            }
        }
        $fields = [
            'parametre',
            'telephones',
            'adresse',
            'tags',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $user->$field = json_encode($request->$field);
            }
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);

        if ($request->hasfile('image')) {
            $ressource_controller = app()->make(RessourceController::class);
            $filename = $ressource_controller->update($this->path . $user->image, $request->file('image'), $this->path, 500, 500);
            $user->image = $filename;
        }
        // $user->markEmailAsVerified();
        $user->update();
        return back()->with('success', 'Modification effectué avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $ressource_controller = app()->make(RessourceController::class);
        $ressource_controller->destroy($this->path . $user->image);
        $user->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }
}
