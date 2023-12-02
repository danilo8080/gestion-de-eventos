<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Contactos;
use App\Models\Evento;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller ;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\HasApiTokens;

class ActividadController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, HasApiTokens;

    public function create(Request $request){
        $rules = [
            'valor'       => 'required|numeric',
            'descripcion' => 'nullable|string',
            ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message'=> $validator->errors()->all()
            ], Response::HTTP_BAD_REQUEST);
        }

        $data['descripcion'] = $request['descripcion'] ?? null;
        $data['valor']  = $request['valor'];

        try{
            $actividad = Actividad::create($data);
            return response()->json([
                'success' => true,
                'message' => 'Actividad creada con exito!!',
                'actividad' => $actividad
            ], Response::HTTP_CREATED);

        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id){
        try{
            $res = Actividad::find($id)->delete();
            return response()->json(["deleted" => $res], 200);

        }catch(\throwable $th){
             return response()->json([
                'error' => $th->getMessage()
            ], 500);

        }
    }

    public function buscarActividades(int $eventoId) {
        $evento = Evento::find($eventoId);
        $actividades = $evento->actividades()->get();

        return response()->json([
            'success' => true,
            'data'    => $actividades
        ], Response::HTTP_OK);
    }


}
