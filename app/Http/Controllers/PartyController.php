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
     public function index(Request $request)
     {
         $resultado = Party::where('game_id', '=', $request->game_id)->get();
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

    //Crear una party
    public function store(Request $request)

    {
        //

        $this->validate($request, [
            'nombre' => 'required|min:4',
            'game_id' => 'required',

        ]);

        $party = Party::create([
            'nombre' => $request->nombre,
            'game_id' => $request->game_id,

        ]);

        if (!$party) {
            return response() ->json([
                'success' => false,
                'data' => 'No se ha podido crear la party.'], 400);
        } else {
            return response() ->json([
                'success' => true,
                'data' => $party,
            ], 200);
        }


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
