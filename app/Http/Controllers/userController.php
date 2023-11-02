<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller ;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\HasApiTokens;

class UserController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, HasApiTokens;

    public function obtener(){
        try{
            $data = User::get();
            return response()->json($data, 200);
        }
        catch(\throwable $th){
          return response()->json(['error' => $th->getMessage()], 500);

        }
    }

    public function post(Request $request){

        $rules = [
            'email'    => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'nombre'   => 'string|max:100',
            'apodo'    => 'required|string|max:100',
            'foto'     => 'string|max:100',
            ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json(['error'=> $validator->errors()->all()], Response::HTTP_BAD_REQUEST);
        }

        $data['nombre'] = $request['nombre'] ?? null;
        $data['email'] = $request['email'];
        $data['apodo'] = $request['apodo'];
        $data['foto'] = $request['foto'] ?? null;
        $data['password'] = Hash::make($request['password']);

        try{
            $user = User::create($data);
            return response()->json([
                'success' => true,
                'message' => 'Usuario creado con exito!!',
                'user'    => $user,
                'token'   => $user->createToken('API TOKEN')->plainTextToken
            ], Response::HTTP_CREATED);

        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public  function getbyId($id){
        try{
            $data = User::find($id);
            return response()->json($data, 200);

        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], 500);

        }
    }

    public  function put(request $request,$id){
        try{
            $data['nombre'] = $request['nombre'];
            $data['email'] = $request['email'];
            $data['apodo'] = $request['apodo'];
            $data['foto'] = $request['foto'];
            $data['password'] = $request['password'];
            User::find($id)->update($data);
            $res = User::find($id);
            return response()->json($res, 200);

        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], 500);

        }
    }

    public  function delete($id){
        try{
            $res = User::find($id)->delete();
            return response()->json(["deleted" => $res], 200);

        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], 500);

        }
    }
}
