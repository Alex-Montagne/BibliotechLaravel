<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_vinyle_user',
    ];

    /**
     * Les attributs qui doivent être cachés pendant la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Récupère les attributs qui doivent être convertis.
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

    /**
     * Vérifier si l'utilisateur est un administrateur
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifier si l'utilisateur est un bibliothécaire
     */
    public function isBibliothecaire(): bool
    {
        return $this->role === 'bibliothécaire';
    }

    /**
     * Vérifier si l'utilisateur est un utilisateur ordinaire
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Vérifier si l'utilisateur a accès aux vinyles
     */
    public function isVinyleUser(): bool
    {
        return $this->is_vinyle_user;
    }
}
