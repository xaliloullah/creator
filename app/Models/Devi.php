<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Auth;

class Devi extends Model
{
    use HasUuids;
    protected $table = 'devis';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($devi) {
            $devi->numero = $devi->generateNumber();
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
        $lastDevi = Devi::where('user_id', Auth::user()->id ?? '')->latest()->first();
        $last = $lastDevi ? intval(substr($lastDevi->numero, -4)) : 0;
        return 'DEV-' . date('dmy') . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }
}
