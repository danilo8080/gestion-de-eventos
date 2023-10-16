<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Usuario extends Authenticatable
{

    protected $primaryKey = 'email';

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "usuario";
     
    

    protected $fillable = [
        'id',
        'email',
        'foto',
        'nombre',
        'apodo',
        'password',

    ];
}
