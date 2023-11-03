<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    use HasFactory;

    public function creador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function participantes()
    {
        return $this->belongsToMany(User::class)->withPivot('acepto')->withTimestamps();
    }
}
