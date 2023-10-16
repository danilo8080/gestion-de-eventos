<?php
//kkkkkk
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use app\Models\Usuario;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function get(){
        try{
            $data = Usuario::get();
            return response()->json($data, 200);
        }
        catch(\throwable $th){
          return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    public  function post(Request $request){
        try{
            $data['id'] = $request['id'];
            $data['nombre'] = $request['nombre'];
            $data['email'] = $request['email'];
            $data['apodo'] = $request['apodo'];
            $data['foto'] = $request['foto'];
            $data['password'] = $request['password'];
            $res = Usuario::post($data);
            return response()->json($res, 200);

        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], 500);

        }
    }

    public  function getbyId($id){
        try{
            $data = Usuario::find($id);
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
            Usuario::find($id)->update($data);
            $res = Usuario::find($id);
            return response()->json($res, 200);

        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], 500);

        }
    }

    public  function delete($id){
        try{
            $res = Usuario::find($id)->delete();
            return response()->json(["deleted" => $res], 200);
            
        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], 500);

        }
    }
}
