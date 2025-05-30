<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Auth;


class Facture extends Model
{
    use HasUuids;
    protected $table = 'factures'; 

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
        $lastFacture = Facture::where('user_id', Auth::user()->id ?? '')->latest()->first();
        $last = $lastFacture ? intval(substr($lastFacture->numero, -4)) : 0;
        return 'FAC-' . date('dmy') . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }
}
