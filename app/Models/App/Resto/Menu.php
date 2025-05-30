<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Traits\HasStatut;
use App\Models\Traits\Jsonify;
use App\Models\Traits\HasImage;

class Menu extends Model
{
    use HasUuids, HasStatut, Jsonify, HasImage;

    public function Plats()
    {
        return $this->hasMany(Plat::class);
    }
}
