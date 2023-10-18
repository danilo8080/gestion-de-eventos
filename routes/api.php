<?php

use App\Http\Controllers\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

   Route::prefix('/v1/Usuario')->group(function(){
    Route::get('/',[UserController::class, 'obtener']);
    // Route::get('/', 'userController@obtener');
    Route::post('/',[UserController::class, 'post']);
    Route::get('/{id}',[UserController::class, 'getbyId']);
    Route::put('/{id}',[UserController::class, 'put']);
    Route::delete('/{id}',[UserController::class, 'delete']);

});

