<?php

namespace Database\Seeders;

// use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bases\Role;
use App\Models\Bases\Statut;

class Users extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $user = User::create([
            'prenom' => 'Creators',
            'email' => 'admin@creator.sn',
            'password' => Hash::make('admin'),
            'statut' => Statut::ACTIVE
       ]);
        $user->markEmailAsVerified();
        $user->assignRole(Role::all());

        // php artisan db:seed


    }
}
