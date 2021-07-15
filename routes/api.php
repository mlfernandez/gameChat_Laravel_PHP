<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    // ruta crud de message
    Route::resource('message', MessageController::class);
    // ruta crud completo de user
    Route::resource('users', UserController::class);
    // ruta para que el usuario haga logout
    Route::post('users/logout', [UserController::class,'logout']); 
    // ruta crud completo de party
    Route::resource('partys', PartyController::class);
    
});