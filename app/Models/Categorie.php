<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Traits\HasStatut;
use App\Models\Traits\Jsonify;
use App\Models\Traits\HasImage;

class Categorie extends Model
{
    use HasUuids, HasStatut, Jsonify, HasImage;

    protected $table = 'categories';

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function Produits()
    {
        return $this->hasMany(Produit::class);
    }

    public function Categories()
    {
        return $this->hasMany(Categorie::class);
    }
}
