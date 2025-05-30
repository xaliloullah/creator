<?php

namespace App\Models\Chats;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Support\Facades\Auth;

use App\Models\Traits\HasStatut;
use App\Models\User;
// use App\Models\Traits\Jsonify;

class Discussion extends Model
{
    use HasStatut, HasUuids;

    protected $table = 'discussions';


    protected $casts = [
        'participants' => 'array',
    ];

    public function Messages()
    {
        return $this->hasMany(Message::class);
    }
 
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Users()
    {
        return $this->belongsToMany(User::class, 'discussion_membres');
    }

    public function Membres()
    {
        return $this->Users()->where('user_id', '!=', Auth::user()->id);
    }

    public function Membre()
    {
        return $this->Membres->first();
    }
    
    public function Image()
    {
        return $this->Membre()->image();
    }

}
