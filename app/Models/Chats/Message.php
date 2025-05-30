<?php

namespace App\Models\Chats;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Auth;
use App\Models\Traits\HasStatut;
use App\Models\User;

class Message extends Model
{
    use HasStatut, HasUuids;

    protected $table = 'messages';

    public function Discussion()
    {
        return $this->belongsTo(Discussion::class, 'discussion_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Reponse()
    {
        return $this->belongsTo(Message::class, 'reponse_id');
    }

    public function Reponses()
    {
        return $this->hasMany(Message::class, 'reponse_id');
    }

    public function scopeUnRead($query)
    {
        return $query->where('user_id', '!=', Auth::user()->id)->where('statut', 'UNREAD');
    }
}
