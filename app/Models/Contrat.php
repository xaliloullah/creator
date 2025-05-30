<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Auth;

class Contrat extends Model
{
    use HasUuids;
    protected $table = 'contrats';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($contrat) {
            $contrat->numero = $contrat->generateNumber();
        });
    }

    public function Client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function generateNumber()
    {
        $lastContrat = Contrat::where('user_id', Auth::user()->id ?? '')->latest()->first();
        $last = $lastContrat ? intval(substr($lastContrat->numero, -4)) : 0;
        return 'CTT-' . date('dmy') . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }
}
