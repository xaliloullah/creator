<?php

namespace App\Models\RH;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Traits\HasStatut;
use App\Models\Traits\Jsonify;
// use App\Models\Traits\HasImage;
use App\Models\Traits\HasDevise;

class Poste extends Model
{
    use HasUuids, HasStatut, Jsonify, HasDevise;

    protected $table = 'postes';
}
