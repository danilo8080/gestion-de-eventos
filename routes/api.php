<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Route::post('/v1/Usuario',[UserController::class, 'post'])->name('create');
// Route::post('auth/login', [AuthController::class,'login'])->name('login');

// Route::middleware(['auth:sanctum'])->group(function () {
// });

// Route::post('auth/logout', [AuthController::class,'logout'])->name('logout');
Route::prefix('/v1/Usuario')->group(function(){
    Route::get('/',[UserController::class, 'obtener'])->name('obtener');
    Route::post('/',[UserController::class, 'post'])->name('create');
    Route::get('/{id}',[UserController::class, 'getbyId']);
    Route::put('/{id}',[UserController::class, 'put']);
    Route::delete('/{id}',[UserController::class, 'delete']);

});
