<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controller\userController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
   });

   Route::prefix('v1/Usuario')->group(function(){
    Route::get('/',[userController::class, 'obtener']);
    Route::post('/',[userController::class, 'post']);
    Route::get('/{id}',[userController::class, 'getbyId']);
    Route::put('/{id}',[userController::class, 'put']);
    Route::delete('/{id}',[userController::class, 'delete']);

}); 

