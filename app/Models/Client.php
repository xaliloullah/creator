<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Traits\HasImage;
use App\Models\Traits\HasStatut;
use App\Models\Traits\Jsonify;

class Client extends Model
{
    use HasUuids, HasImage, HasStatut, Jsonify;
    protected $table = 'clients';
}
