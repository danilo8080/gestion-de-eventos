<?php
//kkkkkk
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use app\model\Usuario;


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
            $data['nombre'] = $request['nombre'];
            $data['email'] = $request['email'];
            $data['apodo'] = $request['apodo'];
            $data['foto'] = $request['foto'];
            $data['password'] = $request['password'];
            $res = Usuario::post($data);
            return respond->json($res, 200);

        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], 500);

        }
    }

    public  function getbyId($email){
        try{
            $data = Usuario::find($email);
            return respond->json($data, 200);
            
        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], 500);

        }
    }

    public  function put(request $request,$email){
        try{
            $data['nombre'] = $request['nombre'];
            $data['email'] = $request['email'];
            $data['apodo'] = $request['apodo'];
            $data['foto'] = $request['foto'];
            $data['password'] = $request['password'];
            Usuario::find($email)->update($data);
            $res = Usuario::find($email);
            return respond->json($res, 200);

        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], 500);

        }
    }

    public  function delete($email){
        try{
            $res = Usuario::find($email)->delete();
            return respond->json(["deleted" => $res], 200);
            
        }catch(\throwable $th){
             return response()->json(['error' => $th->getMessage()], 500);

        }
    }
}
