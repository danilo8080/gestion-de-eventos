<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller ;
use App\Models\User;


class UserController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function obtener(){
        try{
            $data = User::get();
            return response()->json($data, 200);
        }
        catch(\throwable $th){
          return response()->json(['error' => $th->getMessage()], 500);

        }
    }


    public  function post(Request $request){
        try{

            $data['nombre'] = $request['nombre'];
            $data['email'] = $request['email'];
            $data['apodo'] = $request['apodo'];
            $data['foto'] = $request['foto'];
            $data['password'] = $request['password'];
            $res = User::create($data);
            return response()->json($res, 201);

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
