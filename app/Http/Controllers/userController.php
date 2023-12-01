<?php

namespace App\Http\Controllers;

use App\Models\Contactos;
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

class UserController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, HasApiTokens;

    public function obtener(){
        try{
            $data = User::get();
            return response()->json($data, 200);
        }
        catch(\throwable $th){
          return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function base64ToImage($base64_string, $output_file) {
        $data = explode(',', $base64_string);
        if (isset($data[1])) {
            $ifp = fopen($output_file, "wb");
            fwrite($ifp, base64_decode($data[1]));
            fclose($ifp);
            return $output_file;
        } else {
            return false;
        }
    }

    public function post(Request $request){
        $rules = [
            'email'    => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'nombre'   => 'nullable|string|max:100',
            'apodo'    => 'required|string|max:100',
            'foto'     => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message'=> $validator->errors()->all()
            ], Response::HTTP_BAD_REQUEST);
        }


        if ($request->hasFile('foto')) {
            $nombreImagen = time().'.'.$request->foto->extension();
            $request->foto->move(public_path('perfilImagenes'), $nombreImagen);
        } else {
            $nombreImagen = 'default.jpg';
        }

        $data['nombre'] = $request['nombre'] ?? null;
        $data['email']  = $request['email'];
        $data['apodo']  = $request['apodo'];
        $data['foto']   = $nombreImagen;
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
             return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public  function put(request $request, int $id){
        $request = $request->all();
        $rules = [
            'password' => 'string|min:6',
            'nombre'   => 'string|max:100',
            'apodo'    => 'string|max:100',
            'foto'     => 'string|max:100',
            ];

        $validator = Validator::make($request, $rules);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message'=> $validator->errors()->all()
            ], Response::HTTP_BAD_REQUEST);
        }

        try{
            $user = User::find($id);
            $data['nombre'] = $request['nombre'] ?? $user->nombre;
            $data['apodo'] = $request['apodo'] ?? $user->apodo;
            $data['foto'] = $request['foto'] ?? $user->foto;
            $data['password'] = $request['password'] ?? $user->password;
            $user->update($data);
            return response()->json($user, 200);

        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public  function delete(int $id){
        try{
            $res = User::find($id)->delete();
            return response()->json(["deleted" => $res], 200);

        }catch(\throwable $th){
             return response()->json([
                'error' => $th->getMessage()
            ], 500);

        }
    }

    public function crearContacto(string $email) {

        $contactoUser = User::where('email', $email)->first();

        if(!$contactoUser){
            return response()->json([
                        'success' => false,
                        'message' => "El contacto con email: $email no existe"
                    ], Response::HTTP_NOT_FOUND);
        }

        $sessionUser = Auth::user();
        $user = User::find($sessionUser->id);

        $existingContacts = $user->contactos()->pluck('users.id')->toArray();

        $user->contactos()->syncWithoutDetaching([$contactoUser->id]);

        $newContacts = $user->contactos()->pluck('users.id')->toArray();

        $addedContacts = array_diff($newContacts, $existingContacts);

        if (count($addedContacts) > 0) {

            return response()->json([
                'success'  => true,
                'message'  => 'Contacto agregado con exito!!',
                'contacto' => $contactoUser
            ], Response::HTTP_OK);

        } else {
            return response()->json([
                'success' => false,
                'message' => "El contacto con email: $email ya se encuentra en su lista de contactos"
            ], Response::HTTP_CONFLICT);
        }

    }

    public function eliminarContacto(string $email) {

        $contactoUser = User::where("email", $email)->first();

        if (!$contactoUser) {
            return response()->json([
                'success' => false,
                'message' => "El contacto con email: $email no existe"
            ], Response::HTTP_NOT_FOUND);
        }

        $sessionUser = Auth::user();
        $user = User::find($sessionUser->id);

        $user->contactos()->detach($contactoUser->id);

        return response()->json([
                'success'  => true,
                'message'  => "El contacto $contactoUser->nombre ha sido eliminado de su lista de contactos." ,
                'contacto' => $email
            ], Response::HTTP_OK);
    }

    public function listarContactos(?string $referencia = '') {

        $user = User::find(Auth::user()->id);
        $contactos = $user->contactos()->where('email', 'LIKE', "%$referencia%")->get();

        $contactos = User::getFotos($contactos->toArray());

        return response()->json([
            'success' => true,
            'data'    => $contactos
        ], Response::HTTP_OK);
    }
    // public function listarContactos() {

    //     $user = User::find(Auth::user()->id);
    //     $contactos = $user->contactos()->get();

    //     $contactos = User::getFotos($contactos->toArray());

    //     return response()->json([
    //         'success' => true,
    //         'data'    => $contactos
    //     ], Response::HTTP_OK);
    // }

    public function buscarUsuarios(?string $referencia = null) {
        $referencia = $referencia ?? '';
        $userModel = new User();

        $userId = Auth::user()->id;
        $usuarios = $userModel->buscarUsuariosPorReferencia($referencia, $userId);

        $usuarios = User::getFotos($usuarios);

        return response()->json([
            'success' => true,
            'data'    => $usuarios
        ], Response::HTTP_OK);
    }


}
