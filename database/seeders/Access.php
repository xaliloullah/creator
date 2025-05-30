<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bases\Role;
use App\Models\Bases\Permission;
use App\Models\Bases\Module;

class Access extends Seeder
{
    /**
     * Run the database seeds.
     */

    private function getPermissions($modules, &$permissions = [])
    {
        foreach ($modules as $module) {
            $permissions[$module->value] = $module->name;
            if ($module->submodules) {
                $this->getPermissions($module->submodules, $permissions);
            }
        }
        return $permissions;
    }

    public function run(): void
    {
        $modules = Module::all();
        $permissions = $this->getPermissions($modules);
         
        foreach ($permissions as $name => $designation) {
            Permission::create([
                'name' => $name,
                'designation' => $designation
            ]);
        }
        $superRole = Role::create([
            'name' => 'super',
            'designation' => 'Super Administrateur',
            'color' => 'danger',
            'icon' => 'bi-shield-lock',
        ]);
        $adminRole = Role::create([
            'name' => 'admin',
            'designation' => 'Administrateur',
            'color' => 'danger',
            'icon' => 'bi-shield-lock',
        ]);

        $developerRole = Role::create([
            'name' => 'developer',
            'designation' => 'Developpeur',
            'color' => 'dark',
            'icon' => 'bi-code-slash',
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'designation' => 'Utilisateur',
            'color' => 'secondary',
            'icon' => 'bi-person',
        ]);

        $superRole->givePermissionTo(Permission::all());
        $adminRole->givePermissionTo(Permission::all());
        // $modules = Module::user();
        // $permissions = $this->getPermissions($modules);
        // $developerRole->givePermissionTo(['create', 'edit']);
        // $userRole->givePermissionTo(['show']);
    }
}
