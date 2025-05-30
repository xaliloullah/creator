<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasStatut;
use App\Models\Traits\Jsonify;

class Journal extends Model
{
    use  HasStatut, Jsonify;
}
