<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bases\Role;
use App\Models\Bases\Permission;
use App\Models\Module;

class Access extends Seeder
{
    /**
     * Run the database seeds.
     */

    // private function getPermissions($modules, &$permissions = [])
    // {
    //     foreach ($modules as $module) {
    //         $permissions[$module->value] = $module->name;
    //         if ($module->submodules) {
    //             $this->getPermissions($module->submodules, $permissions);
    //         }
    //     }
    //     return $permissions;
    // }

    public function run(): void
    {
        $modules = Module::all();
        // $permissions = $this->getPermissions($modules);
         
        foreach ($modules as $module) {
            Permission::create([
                'name' => $module->name,
                'designation' => $module->designation
            ]);
        }
        
        $adminRole = Role::create([
            'name' => 'admin',
            'designation' => 'Administrateur',
            'color' => 'danger',
            'icon' => 'bi bi-shield-lock',
        ]);

        $developerRole = Role::create([
            'name' => 'developer',
            'designation' => 'Developpeur',
            'color' => 'dark',
            'icon' => 'bi bi-code-slash',
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'designation' => 'Utilisateur',
            'color' => 'secondary',
            'icon' => 'bi bi-person',
        ]);
 
        $adminRole->givePermissionTo(Permission::all()); 
        $userRole->givePermissionTo(['dashboard']); 
    }
}
