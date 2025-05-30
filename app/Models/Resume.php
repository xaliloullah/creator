<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Traits\HasStatut;
use App\Models\Traits\Jsonify;
use App\Models\Traits\HasImage;

class Resume extends Model
{
    use HasUuids, Jsonify, HasStatut, HasImage;

    protected $table = 'resumes';

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
