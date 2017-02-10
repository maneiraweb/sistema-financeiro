<?php

namespace SisFin\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use SisFin\Models\Cliente;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function getJWTIdentifier() {
        return $this->id;
    }

    public function getJWTCustomClaims() {
        return [
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email
            ]
        ];
    }
}
