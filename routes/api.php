<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\EventosUserController;
use App\Http\Controllers\userController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
//    });

Route::post('v1/usuario',[UserController::class, 'post'])->name('create');
Route::post('auth/login', [AuthController::class,'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {

    // rutas usuarios
    // Route::get('v1/usuario',[UserController::class, 'obtener'])->name('obtener');
    Route::get('v1/usuarios/buscar/{referencia?}',[UserController::class, 'buscarUsuarios']);
    // Route::get('v1/usuario/{id}',[UserController::class, 'getbyId']);
    Route::put('v1/usuario/{email}',[UserController::class, 'put']);
    Route::delete('v1/usuario/{email}',[UserController::class, 'delete']);
    Route::post('auth/logout', [AuthController::class,'logout']);

    // rutas contactos
    Route::get('v1/listarcontactos/{referencia?}', [UserController::class,'listarContactos']);
    Route::get('v1/crearcontacto/{email}', [UserController::class,'crearContacto']);
    Route::delete('v1/eliminarcontacto/{email}', [UserController::class,'eliminarContacto']);

    // rutas eventos
    Route::post('v1/crearevento', [EventosController::class,'store']);
    Route::put('v1/editarevento/{id}', [EventosController::class,'update']);
    Route::get('v1/listareventos/{nombre?}', [EventosController::class,'buscarEventos']);
    Route::delete('v1/eliminarevento/{id}', [EventosController::class,'delete']);

    Route::post('v1/agregarcontacto/{eventoId}', [EventosUserController::class,'agregarContacto']);
    Route::delete('v1/eliminarcontacto/evento/{eventoId}/{contactoId}', [EventosUserController::class,'eliminarContacto']);

});

