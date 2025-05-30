<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Traits\HasStatut;
use App\Models\Traits\Jsonify;
use App\Models\Traits\HasImage;

class Plat extends Model
{
    use HasUuids, HasStatut, Jsonify, HasImage;


    public function Menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
