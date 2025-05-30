<?php

namespace App\Models\Traits;

use App\Models\Bases\Statut;
use Illuminate\Support\Collection;

trait HasStatut
{
    public function getStatutAttribute($value = null): Statut|Collection|null
    {
        if (is_array($value)) {
            return collect($value)->map(fn($v) => Statut::get($v));
        }
        if (is_null($value)) {
            return null;
        }
        return Statut::get($value);
    }
}
