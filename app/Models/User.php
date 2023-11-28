<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

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

    public static function getContactos(int $userId): array
    {
        $contactos = DB::table('contactos')
                        ->join('users', 'contactos.email', '=', 'users.email')
                        ->where('contactos.user_id', $userId)
                        ->get();

        return $contactos->toArray();
    }



    public static function buscarUsuariosPorReferencia(string $referencia, int $userId): array
    {
        // $usuarios = User::where(function ($query) use ($referencia) {
        //     $query->where('email', 'LIKE', "%$referencia%")
        //           ->orWhere('apodo', 'LIKE', "%$referencia%")
        //           ->orWhere('nombre', 'LIKE', "%$referencia%");
        // })
        // ->where('id', '!=', $userId)


        $usuarios = User::contactos();

        // ->whereDoesntHave('contactos', function ($query) use ($userId) {
        //     $query->where('user_id', $userId);
        // })
        // ->get();

        $usuariosToArray = $usuarios->toArray();

        return $usuariosToArray;
    }

    public function contactos()
    {
        return $this->belongsToMany(User::class, 'user_contacts', 'user_id', 'contact_id');
    }

    public function eventos()
    {
        return $this->belongsToMany(Eventos::class)->withPivot('acepto')->withTimestamps();
    }
}
