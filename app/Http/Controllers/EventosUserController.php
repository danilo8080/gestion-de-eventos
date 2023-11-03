<?php

namespace App\Http\Controllers;

use App\Models\Eventos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EventosUserController extends Controller
{
    public function agregarContacto(Request $request, int $eventoId)
    {
        $evento = Eventos::findOrFail($eventoId);
        if ($evento->user_id != Auth::id()) {
            return response()->json(['message' => 'No tienes permiso para agregar contactos a este evento'], Response::HTTP_FORBIDDEN);
        }
        $contacto = User::where('email', $request->email)->first();

        if (!$contacto) {
            return response()->json(['message' => 'El usuario con el email especificado no existe'], Response::HTTP_NOT_FOUND);
        }

        if ($evento->participantes()->contains($contacto)) {
            return response()->json(['message' => 'El contacto ya está agregado al evento'], Response::HTTP_CONFLICT);
        }

        $evento->participantes->attach($contacto);

        return response()->json(['message' => 'Contacto agregado exitosamente'], Response::HTTP_OK);
    }

    public function eliminarContacto(int $eventoId, int $contactoId)
    {
        $evento = Eventos::findOrFail($eventoId);

        if ($evento->user_id != Auth::id()) {
            return response()->json(['message' => 'No tienes permiso para quitar contactos de este evento'], Response::HTTP_FORBIDDEN);
        }

        // pendiente cuando se agreguen las actividades
        // if ($evento->actividades->exists()) {
        //     return response()->json(['message' => 'No se pueden quitar contactos si ya hay actividades registradas'], 403);
        // }

        $contacto = User::findOrFail($contactoId);

        if (!$evento->participants->contains($contacto)) {
            return response()->json(['message' => 'El contacto no está agregado al evento']);
        }

        $evento->participantes->detach($contacto);

        return response()->json(['message' => 'Contacto removido exitosamente'], Response::HTTP_OK);
    }
}
