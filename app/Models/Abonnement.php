<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Carbon\Carbon;

class Abonnement extends Model
{
    use HasUuids;
    protected $table = 'abonnements';

    const STATUT_EN_ATTENTE = 'en attente';
    const STATUT_ACTIF = 'actif';
    const STATUT_EXPIRE = 'expiré';

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($abonnement) {
            if ($abonnement->date_fin && $abonnement->date_fin <= $abonnement->date_debut) {
                throw new \Exception("La date de fin doit être après la date de début.");
            }
        });
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Tarif()
    {
        return $this->belongsTo(Tarif::class, 'tarif_id');
    }

    public function Paiement()
    {
        return $this->hasOne(Paiement::class);
    }


    public function isActive()
    {
        $now = Carbon::now();

        return Carbon::parse($this->date_debut)->isBefore($now) && Carbon::parse($this->date_fin)->isAfter($now);
    }

    public function getStatut()
    {

        if (Carbon::parse($this->date_debut)->isFuture()) {
            return 'à venir';
        }

        if (Carbon::parse($this->date_fin)->isPast()) {
            return 'expiré';
        }

        return 'actif';
    }
}
