<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EventosUserController extends Controller
{
    public function agregarContacto(Request $request, int $eventoId)
    {
        $evento = Evento::findOrFail($eventoId);
        if ($evento->user_id != Auth::id()) {
            return response()->json(['message' => 'No tienes permiso para agregar contactos a este evento'], Response::HTTP_FORBIDDEN);
        }
        $contacto = User::where('email', $request->email)->first();

        if (!$contacto) {
            return response()->json(['message' => 'El usuario con el email '. $request->email .' no existe'], Response::HTTP_NOT_FOUND);
        }

        $existeEvento = $evento->participantes()->pluck('users.id')->toArray();

        $evento->participantes()->syncWithoutDetaching([$contacto->id]);

        $nuevosEventos = $evento->participantes()->pluck('users.id')->toArray();

        $seAgregoEvento = array_diff($nuevosEventos, $existeEvento);

        if (count($seAgregoEvento) > 0) {

            return response()->json([
                'success'  => true,
                'message'  => 'Contacto agregado con exito!!',
                'evento'   => $evento
            ], Response::HTTP_OK);

        } else {
            return response()->json([
                'success' => false,
                'message' => "El contacto $contacto->nombre ya está agregado al evento"
            ], Response::HTTP_CONFLICT);
        }
    }

    public function eliminarContacto(int $eventoId, int $contactoId)
    {
        $evento = Evento::findOrFail($eventoId);

        if ($evento->user_id != Auth::id()) {
            return response()->json(['message' => 'No tienes permiso para quitar contactos de este evento'], Response::HTTP_FORBIDDEN);
        }

        // pendiente cuando se agreguen las actividades
        // if ($evento->actividades->exists()) {
        //     return response()->json(['message' => 'No se pueden quitar contactos si ya hay actividades registradas'], 403);
        // }

        $contacto = User::findOrFail($contactoId);

        // if (!$evento->participants->contains($contacto)) {
        //     return response()->json(['message' => 'El contacto no está agregado al evento']);
        // }

        $evento->participantes->detach($contacto);

        return response()->json(['message' => 'Contacto removido exitosamente'], Response::HTTP_OK);
    }
}
