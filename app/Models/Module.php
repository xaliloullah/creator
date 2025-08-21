<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasStatut; 

class Module extends Model
{
    use HasStatut;
    protected $fillable = [
        'value',
        'name',
        'color',
        'icon',
        'statut',
        'lock',
        'route',
        'link',
        'hidden',
        'target',
        'description',
        'tags',
        'module_id'
    ];

    protected $casts = [
        'lock' => 'boolean',
        'hidden' => 'boolean',
        'tags' => 'array'
    ];

    public function Parent()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function submodules()
    {
        return $this->hasMany(Module::class, 'module_id');
    }

    public function hasSubmodules()
    {
        return $this->submodules()->exists();
    }

    public function isLocked()
    {
        /** @var User $user */
        $user = Auth::user();
        return $this->lock && $user && $user->cannot($this->name);
    }

    public function isHidden()
    {
        /** @var User $user */
        $user = Auth::user();
        return $this->hidden || $user && $user->cannot($this->name);
    }

    public function isVisible()
    {
        return !$this->isHidden();
    } 
}
