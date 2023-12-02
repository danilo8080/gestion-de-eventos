<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
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

    // public static function getContactos(int $userId): array
    // {
    //     $contactos = DB::table('contactos')
    //                     ->join('users', 'contactos.email', '=', 'users.email')
    //                     ->where('contactos.user_id', $userId)
    //                     ->get();

    //     return $contactos->toArray();
    // }



    public static function buscarUsuariosPorReferencia(string $referencia, int $usuarioLogueadoId): array
    {
        $nonContactUsers = User::whereNotIn('id', function($query) use ($usuarioLogueadoId) {
            $query->select('contact_id')
                  ->from('user_contacts')
                  ->where('user_id', $usuarioLogueadoId);
        })->where(function ($query) use ($referencia) {
                $query->where('email', 'LIKE', "%$referencia%")
                      ->orWhere('apodo', 'LIKE', "%$referencia%")
                      ->orWhere('nombre', 'LIKE', "%$referencia%");
            })
        ->get();

        $usuariosToArray = $nonContactUsers->toArray();

        return $usuariosToArray;
    }

    public static function getFotos(array $usuarios): array
    {
        foreach ($usuarios as &$usuario) {
            if($usuario['foto'] == null) {
                continue;
            }
            $path = public_path('perfilImagenes/'.$usuario['foto']);
            $usuario['foto'] = base64_encode(file_get_contents($path));
            // dd($usuario['foto']);
        }
        // dd($usuarios);
        return $usuarios;
    }

    public function contactos()
    {
        return $this->belongsToMany(User::class, 'user_contacts', 'user_id', 'contact_id');
    }

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'evento_user');
    }
}
