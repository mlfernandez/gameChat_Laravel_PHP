<?php

namespace App\Http\Controllers;

use App\Models\PartyUser;
use Illuminate\Http\Request;

class PartyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if($user->id === 15){

            $partyuser = PartyUser::all();

            return response() ->json([
                'success' => true,
                'data' => $partyuser,
            ]);
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'No tienes permiso de administrador para realizar esta acción.',
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        // ruta crear agregar un usuario a una party
        // Crear una party POST https://gamechat-laravel-mlf.herokuapp.com/api/partyusers
        // Postman: necesita "token" y "party_id" por body
    public function store(Request $request)
    {
        $user = auth()->user();

        $this->validate( $request , [
            'party_id' => 'required',
        ]);

        $partyuser = PartyUser::create ([
            'user_id' => $user -> id,
            'party_id' => $request -> party_id,
        ]);

        if ($partyuser) {

            return response() ->json([
                'success' => true,
                'data' => $partyuser
            ], 200);
    
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'No se pudo agregar el usuario a la party',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartyUser  $partyUser
     * @return \Illuminate\Http\Response
     */


        // ruta busca las partys de un usuario
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/partyusers/showByUser
        // Postman: necestia "token", "user_id" por body 
    public function showByUser()
    {
        $user = auth()->user();

        $partyuser = PartyUser::where('user_id', '=', $user->id)->get();

        if($user->id){

            return response() ->json([
                'success' => true,
                'data' => $partyuser,
            ]);

        } else {

            return response() ->json([
                'success' => false,
                'message' => 'No tienes permiso de administrador para realizar esta acción.',
            ], 400);

        }
    }

        // ruta busca las partys de un usuario
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/partyusers/showByParty
        // Postman: necestia "token", "party_id" por body 
    public function showByParty(Request $request)
    {
        $user = auth()->user();

        $partyuser = PartyUser::where('party_id', '=',  $request -> party_id)->get();


        if($user->id){

            return response() ->json([
                'success' => true,
                'data' => $partyuser,
            ]);

        } else {

            return response() ->json([
                'success' => false,
                'message' => 'No tienes permiso de administrador para realizar esta acción.',
            ], 400);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PartyUser  $partyUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartyUser $partyUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartyUser  $partyUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();
        $user_id = $request->id_user;
        $party_id = $request->id_party;

        if($user->id === $user_id){

            $resultado = PartyUser::where('party_id', $party_id AND 'user_id', $user_id);
            if (!$resultado) {
                return response() ->json([
                    'success' => false,
                    'data' => 'No se ha encontrado ningun Party.'], 400);
            } 
            if ($resultado -> delete()) {
                return response() ->json([
                    'success' => true,
                    'message' => 'El usuario ha aboandonado la Party.'], 200);
            } else {
                return response() ->json([
                    'success' => false,
                    'message' => 'No se ha podido realizar esa acción'
                ], 500);
            }
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'No tienes permisos para realizar esa acción.',
            ], 400);
        }
    }

}
