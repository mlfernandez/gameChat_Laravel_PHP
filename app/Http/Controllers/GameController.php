<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        // ruta crear game
        // Crear una party POST https://gamechat-laravel-mlf.herokuapp.com/api/games
        // Postman: necesita "token" y "title", "images" y "url" por body
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required|min:4',
            'images' => 'required',
            'url' => 'required',

        ]);

        $game = Game::create([
            'title' => $request->title,
            'images' => $request->images,
            'url' => $request->url,
        ]);

        if (!$game) {
            return response() ->json([
                'success' => false,
                'data' => 'No se ha podido crear el game.'], 400);
        } else {
            return response() ->json([
                'success' => true,
                'data' => $game,
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
        // Muestra todas los games
        // GET https://gamechat-laravel-mlf.herokuapp.com/api/games 
        // Postman: necestia "token"
    public function show()
    {
        $games = Game::all();

        if(!$games){
            return response() ->json([
                'success' => false,
                'message' => 'No se ha encontrado ningun Game',
            ], 400);
        }

        return response() ->json([
            'success' => true,
            'data' => $games,
        ]);
    }

        // ruta busca games por nombre game
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/games/showByName
        // Postman: necestia "token" y "title" por body
    public function showByName(Request $request)
    {
        $resultado = Game::where('title', '=', $request->title)->get();
        if ($resultado == []) {
            return response() ->json([
                'success' => false,
                'data' => 'No se ha encontrado ningun Game con ese título: .' . $request->title], 400);
        } else {
            return response() ->json([
                'success' => true,
                'data' => $resultado,
            ], 200);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
        // ruta busca games y actualiza
        // PUT https://gamechat-laravel-mlf.herokuapp.com/api/games/
        // Postman: necestia "token" , por ruta "id" y "title", "images" y "url" por body
    public function update(Request $request, $id)
    {
        $resultado = Game::where('id', '=', $id);
        if (!$resultado) {
            return response() ->json([
                'success' => false,
                'data' => 'No se ha encontrado ningun Game.'], 400);
        } 

        $updated = $resultado->update([
            'title' => $request->input('title'),
            'images' => $request->input('images'),
            'url' => $request->input('url'),

        ]);
        if($updated){
            return response() ->json([
                'success' => true,
            ]);
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'El Game no se puede actualizar',
            ], 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
        // ruta busca games y elimina
        // DELETE https://gamechat-laravel-mlf.herokuapp.com/api/games/
        // Postman: necestia "token" , "id" por url
    public function destroy($id)
    {
        $resultado = Game::where('id', '=', $id);
        if (!$resultado) {
            return response() ->json([
                'success' => false,
                'data' => 'No se ha encontrado ningun Game.'], 400);
        } 
        if ($resultado -> delete()) {
            return response() ->json([
                'success' => true,
                'message' => 'Game eliminado.'], 200);
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'No se ha podido eliminar ese Game'
            ], 500);
        }
    }
}
