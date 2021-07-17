<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        // ruta trae las parties por game_id
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/parties 
        // Postman: necestia "token" y "game_id"por body
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

        // ruta crear party
        // Crear una party POST https://gamechat-laravel-mlf.herokuapp.com/api/parties
        // Postman: necesita "token" y "nombre" y "game_id" por body
    public function store(Request $request)

    {
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

        // Muestra todas las parties
        // GET https://gamechat-laravel-mlf.herokuapp.com/api/parties 
        // Postman: necestia "token"
    public function show()
    {
        $parties = Party::all();

        if(!$parties){
            return response() ->json([
                'success' => false,
                'message' => 'No se ha encontrado ninguna Party',
            ], 400);
        }

        return response() ->json([
            'success' => true,
            'data' => $parties,
        ]);
    }

        // ruta busca parties por id de party
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/parties/showById
        // Postman: necestia "token", "id" por body
    public function showById(Request $request)
    {
        $resultado = Party::where('id', '=', $request->id)->get();
        if (!$resultado) {
            return response() ->json([
                'success' => false,
                'data' => 'No se ha encontrado ningun Party.'], 400);

        } elseif ($resultado->isEmpty()) {
            return response() ->json([
                'success' => false,
                'data' => 'No se ha encontrado ningun Party con esa id: ' . $request->id], 400);        
        } else {
            return response() ->json([
                'success' => true,
                'data' => $resultado,
            ], 200);
        }
       
    }

        // ruta busca parties por nombre party
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/parties/showByName
        // Postman: necestia "token" y "nombre" por body
    public function showByName(Request $request)
    {
        $resultado = Party::where('nombre', '=', $request->nombre)->get();
        if (!$resultado) {
            return response() ->json([
                'success' => false,
                'data' => 'No se ha encontrado ningun Party.'], 400);
        } elseif ($resultado->isEmpty()) {
            return response() ->json([
                'success' => false,
                'data' => 'No se ha encontrado ningun Game con ese título: ' . $request->nombre], 400);
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
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */

        // ruta busca parties y actualiza
        // PUT https://gamechat-laravel-mlf.herokuapp.com/api/parties/
        // Postman: necestia "token" , por ruta "id" y "nombre" por body
    public function update(Request $request, $id)
    {
        $resultado = Party::where('id', '=', $id);
        if (!$resultado) {
            return response() ->json([
                'success' => false,
                'data' => 'No se ha encontrado ningun Party.'], 400);
        } 

        $updated = $resultado->update([
            'nombre' => $request->input('nombre'),

        ]);
        if($updated){
            return response() ->json([
                'success' => true,
            ]);
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'La Party no se puede actualizar',
            ], 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */


        // ruta busca parties y elimina
        // DELETE https://gamechat-laravel-mlf.herokuapp.com/api/parties/
        // Postman: necestia "token" , "id" por url
    public function destroy($id)
    {
        $resultado = Party::where('id', '=', $id);
        if (!$resultado) {
            return response() ->json([
                'success' => false,
                'data' => 'No se ha encontrado ningun Party.'], 400);
        } 
        if ($resultado -> delete()) {
            return response() ->json([
                'success' => true,
                'message' => 'Party eliminada.'], 200);
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'No se ha podido eliminar esa Party'
            ], 500);
        }
    }
    
}
