<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Paiement extends Model
{
    use HasUuids;
    protected $table = 'paiements'; 
    public function Abonnement()
    {
        return $this->belongsTo(Abonnement::class);
    }
}
