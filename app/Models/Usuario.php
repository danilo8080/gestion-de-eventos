<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{

    //protected $primaryKey = 'email';

    use HasFactory;

    protected $table = "users";
     
    protected $fillable = [
        'id',
        'email',
        'foto',
        'nombre',
        'apodo',
        'password',

    ];
}
