<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Buscar una party por game_id
     public function index($game_id)
     {
         $resultado = Party::where('game_id', '=', $game_id)->get();
         if (!$resultado) {
             return response() ->json([
                 'success' => false,
                 'data' => 'No se ha encontrado ningun Party con ese juego.'], 400);
         } else {
             return response() ->json([
                 'success' => true,
                 'data' => $resultado,
             ], 200);
         }
         }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function show(Party $party)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Party $party)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party $party)
    {
        //
    }
}
