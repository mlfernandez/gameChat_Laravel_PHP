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



    public function show(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }
}
