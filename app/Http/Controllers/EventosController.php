<?php

namespace App\Http\Controllers;

use App\Models\Eventos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;

class EventosController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'required|string|max:300',
            'tipo'        => 'required|string|max:30',
            'avatar'      => 'string|max:100',
        ]);

        $user = Auth::user();

        $evento = new Eventos;
        $evento->nombre      = $validatedData['nombre'];
        $evento->descripcion = $validatedData['descripcion'];
        $evento->tipo        = $validatedData['tipo'];
        $evento->avatar      = $validatedData['avatar'] ?? '';
        $evento->user_id     = $user->id;
        $evento->save();

        return response()->json(['message' => 'Evento creado exitosamente'], Response::HTTP_CREATED);
    }

    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'nombre'      => 'string|max:100',
            'descripcion' => 'string|max:300',
            'tipo'        => 'string|max:30',
            'avatar'      => 'string|max:100',
        ]);

        $evento = Eventos::findOrFail($id);

        if ($evento->user_id != Auth::id()) {
            return response()->json(['message' => 'No tienes permiso para modificar este evento'], Response::HTTP_FORBIDDEN);
        }

        $evento->nombre      = $validatedData['nombre'] ?? $evento->nombre;
        $evento->descripcion = $validatedData['descripcion'] ?? $evento->descripcion;
        $evento->tipo        = $validatedData['tipo'] ?? $evento->tipo;
        $evento->avatar      = $validatedData['avatar'] ?? $evento->avatar;
        $evento->save();

        return response()->json(['message' => 'Evento modificado exitosamente'], Response::HTTP_OK);
    }
}
