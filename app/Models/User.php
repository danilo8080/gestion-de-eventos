<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;

    public $table = "users";

    // protected $primaryKey = 'email';

    protected $fillable = [
        'id',
        'email',
        'foto',
        'nombre',
        'apodo',
        'password'
    ];

     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    public function contactos()
    {
        return $this->hasMany(Contactos::class);
    }

    public function eventos()
    {
        return $this->belongsToMany(Eventos::class)->withPivot('acepto')->withTimestamps();
    }
}
