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
            return return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    public  function post(Request $request){
        try{
            

        }catch(){}
    }
}
