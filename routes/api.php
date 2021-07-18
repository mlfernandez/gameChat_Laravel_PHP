<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PartyUserController;

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

// POST https://gamechat-laravel-mlf.herokuapp.com/api/register
// Postman: necesita username, email, password y name
Route::post('register', [PassportAuthController::class, 'register']);

// LOGIN POST https://gamechat-laravel-mlf.herokuapp.com/api/login
// Postman: necesita email y password por body
Route::post('login', [PassportAuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {

    // USER // 

        // ruta crud completo de user
    Route::resource('users', UserController::class);

        // ruta para que el usuario haga logout
    Route::post('users/logout', [UserController::class,'logout']); 

     // PARTIES // 

        // ruta trae las parties por game_id
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/parties 
        // Postman: necestia token y game_id por body
    Route::post('parties', [PartyController::class, 'index']);

        // ruta crear party
        // Crear una party POST https://gamechat-laravel-mlf.herokuapp.com/api/parties
        // Postman: necesita token y nombre y game_id por body
    Route::resource('parties', PartyController::class);

        // ruta trae todas las parties
        // GET https://gamechat-laravel-mlf.herokuapp.com/api/parties 
        // Postman: necestia token
    Route::get('parties', [PartyController::class, 'show']);

        // ruta busca parties por id de party
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/parties/showById
        // Postman: necestia "token", "id" por body
    Route::post('parties/showById', [PartyController::class, 'showById']);

        // ruta busca parties por nombre party
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/parties/showByName
        // Postman: necestia "token" y "nombre" por body
    Route::post('parties/showByName', [PartyController::class, 'showByName']);

     // GAMES // 

        // ruta CRUD game
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/games 
        // Postman: necestia "token" y "title" por body
    Route::resource('games', GameController::class);

        // ruta trae todos los games
        // GET https://gamechat-laravel-mlf.herokuapp.com/api/games 
        // Postman: necestia token
    Route::get('games', [GameController::class, 'show']);

        // ruta busca games por nombre game
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/games/showByName
        // Postman: necestia "token" y "title" por body
    Route::post('games/showByName', [GameController::class, 'showByName']);


     // MESSAGES // 

        // ruta CRUD message
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/messages 
        // Postman: necestia "token" y "text", "user_id" y "party_id" por body
    Route::resource('messages', MessageController::class);

        // ruta trae todos los message
        // GET https://gamechat-laravel-mlf.herokuapp.com/api/messages 
        // Postman: necestia token admin
    Route::get('messages', [MessageController::class, 'show']);

        // ruta busca message por id user
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/messages/showByUserId
        // Postman: necestia "token" admin y "id" por url
    Route::post('messages/showByUserId', [MessageController::class, 'showByUserId']);

        // ruta busca message por id de party
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/messages/showByPartyId
        // Postman: necestia "token"  y "party_id" por body
    Route::post('messages/showByPartyId', [MessageController::class, 'showByPartyId']);

            // ruta busca message por id de party
            // PUT https://gamechat-laravel-mlf.herokuapp.com/api/messages
            // Postman: necestia "token"  y "party_id" por body
        Route::put('messages', [MessageController::class, 'update']);


     // PARTY USERS // 

        // ruta CRUD partyUser
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/partyusers 
        // Postman: necestia "token" y "text", "user_id" y "party_id" por body
    Route::resource('partyusers', PartyUserController::class);

        // ruta trae todos las partyUser
        // GET https://gamechat-laravel-mlf.herokuapp.com/api/partyusers 
        // Postman: necestia token admin
    Route::get('partyusers', [PartyUserController::class, 'show']);

        // ruta busca partyUser por id usuario
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/partyusers/showByUser
        // Postman: necestia "token" admin y "id" por url
    Route::post('partyusers/showByUser', [PartyUserController::class, 'showByUser']);

        // ruta busca partyUser por id de party
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/partyusers/showByPartyId
        // Postman: necestia "token"  y "party_id" por body
    Route::post('partyusers/showByParty', [PartyUserController::class, 'showByParty']);



    
});