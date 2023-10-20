<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use HasApiTokens;

    public function login(Request $request) {
        $rules = [
            'email'    => 'required|string|email|max:100',
            'password' => 'required|string',
            ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json(['error'=> $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        if(!Auth::attempt($request->only('email','password'))) {
            return response()->json([
                'status' => false,
                'error'  => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = User::where('email', $request->email)->first();
        return response()->json([
            'status'  => true,
            'message' => 'usuario logueado con exito',
            'data'    => $user,
            'token'   => $user->createToken('API TOKEN')->plainTextToken
        ], response::HTTP_OK);
    }

    public function logout() {
        // auth()->user()->tokens()->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Session cerrada'
            ], Response::HTTP_OK);
    }
}
