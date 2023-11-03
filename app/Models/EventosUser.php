<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventosUser extends Model
{
    use HasFactory;

    private $estatus = [
        'acepto' => true,
        'pendiente' => false,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evento()
    {
        return $this->belongsTo(Eventos::class);
    }

    public function aceptado()
    {
        return $this->acepto == self::$estatus['acepto'];
    }
}
