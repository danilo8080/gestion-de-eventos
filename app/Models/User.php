<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $table = "users";

    protected $fillable = [
        'id',
        'email',
        'foto',
        'nombre',
        'apodo',
        'password',

    ];
        



}
