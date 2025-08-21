<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    { 
        $this->call([
            Modules::class,
            Access::class,
            Users::class,
        ]);
    }
}
