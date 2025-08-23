<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Bases\Role;
use App\Models\Bases\Permission;

use App\Models\User;

class AccessController extends Controller
{
    /**
     * Liste tous les rôles et permissions.
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('dashboard.pages.admin.access.index', compact('roles', 'permissions'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('dashboard.pages.admin.access.create', compact('permissions'));
    }

    /**
     * Créer un nouveau rôle.
     */
    public function create_role(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role = new Role;
        $fields = [
            'name',
            'designation',
            'color',
            'icon',
            'description'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $role->$field = $request->$field;
            }
        }
        $fields = [
            'tags'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $role->$field = json_encode($request->$field);
            }
        }
        $role->givePermissionTo($request->permissions);
        $role->save();
        return back()->with('success', 'Rôle créé avec succès');
    }

    public function edit_role($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('dashboard.pages.admin.access.roles.edit', compact('role', 'permissions'));
    }

    public function update_role(Request $request, $id)
    {
        $request->validate([
            'name' => "required|unique:roles,name,$id,id",
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role = Role::findOrFail($id);
        $fields = [
            'name',
            'designation',
            'color',
            'icon',
            'description'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $role->$field = $request->$field;
            }
        }
        $fields = [
            'tags'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $role->$field = json_encode($request->$field);
            }
        }
        $role->syncPermissions($request->permissions);
        $role->update();
        return back()->with('success', 'Rôle modifier avec succès');
    }

    /**
     * Assigner un rôle à un utilisateur.
     */
    public function assign_role(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->assignRole($request->role);
        return back()->with('success', 'Rôle assigné avec succès');
    }

    /**
     * Supprimer un rôle d'un utilisateur.
     */
    public function remove_role(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->removeRole($request->role);
        return back()->with('success', 'Rôle retiré avec succès');
    }

    public function delete_role($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return back()->with('success', 'Rôle supprimer avec succès');
    }

    /**
     * Créer une nouvelle permission.
     */
    public function create_permission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $permission = new Permission;
        $fields = [
            'name',
            'designation',
            'description'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $permission->$field = $request->$field;
            }
        }
        $fields = [
            'tags'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $permission->$field = json_encode($request->$field);
            }
        }
        $permission->save();
        return back()->with('success', 'Permission créée avec succès');
    }

    public function edit_permission($id)
    {
        $permission = Permission::findOrFail($id);
        return view('dashboard.pages.admin.access.permissions.edit', compact('permission'));
    }


    public function update_permission(Request $request, $id)
    {
        $request->validate([
            'name' => "required|unique:permissions,name,{$id},id",
        ]);

        $permission = Permission::findOrFail($id);
        $fields = [
            'name',
            'designation',
            'description'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $permission->$field = $request->$field;
            }
        }
        $fields = [
            'tags'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $permission->$field = json_encode($request->$field);
            }
        }
        $permission->update();
        return back()->with('success', 'Permission modifier avec succès');
    }

    public function delete_permission($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return back()->with('success', 'Permission supprimer avec succès');
    }



    /**
     * Assigner une permission à un role.
     */
    public function assign_permission(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission' => 'required|exists:permissions,name',
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->givePermissionTo($request->permission);
        return back()->with('success', 'Permission assignée avec succès');
    }

    /**
     * Supprimer une permission d'un role.
     */
    public function remove_permission(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission' => 'required|exists:permissions,name',
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->revokePermissionTo($request->permission);

        return back()->with('success', 'Permission retirée avec succès');
    }
}
