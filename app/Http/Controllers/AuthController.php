<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    use HasApiTokens;

    public function login(Request $request) {
        // $newRequest = $request;
        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return response()->json([
                'status' => false,
                'error'  => 'No existe un registro con este email!!'
            ], Response::HTTP_UNAUTHORIZED);
        }
        if(!Auth::attempt($request->only('email','password'))) {
            return response()->json([
                'status' => false,
                'error'  => 'Contraseña invalida'
            ], Response::HTTP_UNAUTHORIZED);
        }
        return response()->json([
            'status'  => true,
            'message' => 'usuario logueado con exito',
            'data'    => $user,
            'token'   => $user->createToken('API TOKEN')->plainTextToken
        ], response::HTTP_OK);
    }

    public function logout() {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Session cerrada'
            ], Response::HTTP_OK);
    }
}
