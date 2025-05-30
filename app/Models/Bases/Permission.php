<?php

namespace App\Models\Bases;

use Spatie\Permission\Models\Permission as Permissions;
use Illuminate\Support\Facades\DB;
// use App\Models\Traits\HasStatut;
use App\Models\Traits\Jsonify;

class Permission extends Permissions
{
    use Jsonify;

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($permission) {
            DB::statement("ALTER TABLE permissions AUTO_INCREMENT = 1;");
        });
    }
}
