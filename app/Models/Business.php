<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Business extends Model
{
    protected $table = 'businesses';

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($business) {
            DB::statement("ALTER TABLE businesses AUTO_INCREMENT = 1;");
        });
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
