<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    use HasFactory;

    public static function buscarEventosPorReferencia(string $referencia, int $usuarioLogueadoId): array
    {
        $eventos = Eventos::where('nombre', 'LIKE', "%$referencia%")
                            ->where('user_id', $usuarioLogueadoId)
                            ->get();

        $eventosToArray = $eventos->toArray();

        return $eventosToArray;
    }


    public function creador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function participantes()
    {
        return $this->belongsToMany(User::class)->withPivot('acepto')->withTimestamps();
    }
}
