<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Traits\HasStatut;
use App\Models\Traits\Jsonify;
use App\Models\Traits\HasDevise;

class Tarif extends Model
{
    use HasUuids, HasStatut, Jsonify, HasDevise;

    protected $table = 'tarifs';

    public function getRolesAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true);
    }
    public function getPermissionsAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true);
    }
    public function Abonnements()
    {
        return $this->hasMany(Abonnement::class);
    }
}
