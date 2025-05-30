<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use App\Http\Controllers\EmailController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\HasStatut;
use App\Models\Traits\Jsonify;
use App\Models\Traits\HasImage;
use App\Models\Chats\Discussion;

use App\Models\Bases\Statut;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasStatut, Jsonify, HasImage;
    protected $table = 'users';


    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            DB::statement("ALTER TABLE users AUTO_INCREMENT = 1;");
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'prenom',
        'nom',
        'email',
        'password',
        'roles',
        'telephones',
        'adresse',
        'statut',
        'tags',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }


    public function Discussions()
    {
        return $this->belongsToMany(Discussion::class, 'discussion_membres');
    }

    public function Abonnements()
    {
        return $this->hasMany(Abonnement::class);
    }

    public function Clients()
    {
        return $this->hasMany(Client::class);
    }

    public function Factures()
    {
        return $this->hasMany(Facture::class);
    }

    public function Devis()
    {
        return $this->hasMany(Devi::class);
    }

    public function Resumes()
    {
        return $this->hasMany(Resume::class);
    }

    public function VCards()
    {
        return $this->hasMany(VCard::class);
    }

    public function getEmailStatutAttribute(): Statut
    {
        if ($this->hasVerifiedEmail()) {
            return Statut::get(Statut::VERIFIED);
        }
        return Statut::get(Statut::UNVERIFIED);
    }

    public function sendEmailVerificationNotification()
    {
        $expire_time = 30;
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes($expire_time),
            ['id' => $this->getKey(), 'hash' => sha1($this->getEmailForVerification())]
        );

        $data = [
            'email' => $this->email,
            'user' => $this,
            'url' => $verificationUrl,
            'expire_time' => $expire_time
        ];
        $email_controller = app()->make(EmailController::class);
        $email_controller->SendMail('Vérification de votre adresse email', 'email-verification', $data);
    }


    public function sendPasswordResetNotification($token)
    {
        $expire_time = 30;
        $resetUrl = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes($expire_time),
            ['token' => $token, 'email' => urlencode($this->getEmailForPasswordReset())]
        );

        $data = [
            'email' => $this->email,
            'user' => $this,
            'url' => $resetUrl,
            'expire_time' => $expire_time
        ];

        // Appeler le contrôleur d'email pour envoyer l'email
        $email_controller = app()->make(EmailController::class);
        $email_controller->SendMail('Réinitialisation de votre mot de passe', 'password-reset', $data);
    }
}
