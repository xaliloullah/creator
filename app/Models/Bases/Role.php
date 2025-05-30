<?php

namespace App\Models\Bases;

use Spatie\Permission\Models\Role as Roles;
use Illuminate\Support\Facades\DB;
// use App\Models\Traits\HasStatut;
use App\Models\Traits\Jsonify;

class Role extends Roles
{
    use Jsonify;

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($role) {
            DB::statement("ALTER TABLE roles AUTO_INCREMENT = 1;");
        });
    }
}
