<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Party_User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        // Muestra todos los mensajes
        // GET https://gamechat-laravel-mlf.herokuapp.com/api/messages
        // Postman: necestia "token" de administrador (id 15 Mariana)
    public function index()
    {
        $user = auth()->user();

        $messages = Message::all();

        if($user->id === 15){

            return response() ->json([
                'success' => true,
                'data' => $messages,
            ], 200);

        } else {

            return response() ->json([
                'success' => false,
                'message' => 'No tienes permisos para realizar esta acción.',
            ], 400);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        // ruta crear message
        // Crear un message POST https://gamechat-laravel-mlf.herokuapp.com/api/message
        // Postman: necesita "token" y "text", "user_id" y "party_id" por body
    public function store(Request $request)
    {
        $user = auth()->user();

        $checkUserInParty = Party_User::where('party_id', $request->party_id AND 'user_id', $user->id);

        if ($checkUserInParty === []) {

            $this->validate( $request , [
                'text' => 'required',
                'party_id' => 'required',
            ]);

            $message = Message::create ([
                'text' => $request -> text,
                'user_id' => $user->id,
                'party_id' => $request -> party_id,
            ]);

            if ($message) {
                return response() ->json([
                    'success' => true,
                    'data' => $message
                ], 200);
            } else {

            return response() ->json([
                'success' => false,
                'message' => 'El mensaje no se puedo crear',
            ], 500);
            }
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'El usuario no esta en esa party',
            ], 400);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */


        // ruta busca messages por id
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/games/showByName
        // Postman: necestia "token" del admin (id 15 Mariana) y se pasa id por url
    public function showById($id)
    {
        $user = auth()->user();

        if($user->id === 15){
            
            $message = Message::where('user_id', '=', $id)->get();

            if(!$message){
                return response() ->json([
                    'success' => false,
                    'message' => 'No se encontró mensaje con esa id',
                ], 400);
    
            } elseif ($message->isEmpty()) {
                return response() ->json([
                    'success' => false,
                    'message' => 'No se encontró mensaje con esa id',
                    ], 400);
            } else {    
            return response() ->json([
                'success' => true,
                'data' => $message,
            ], 200);
            }
    
        } else {
    
            return response() ->json([
                'success' => false,
                'message' => 'Necesitas ser administrador para realizar esta acción.',
            ], 400);
    
        }
    }


    public function showByPartyId($id)
    {
        $message = Message::where('party_id', '=', $id)->get();

        if(!$message){
            return response() ->json([
                'success' => false,
                'message' => 'No se ha encontrado ningun mensaje',
            ], 400);

        } elseif ($message->isEmpty()) {
            return response() ->json([
                'success' => false,
                'message' => 'No se ha encontrado ningun mensaje',
                ], 400);

        } else {      
            return response() ->json([
                'success' => true,
                'data' => $message,
            ], 200);
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $userIdMessage = $request->user_id;

        if($user->id === $userIdMessage){

            $resultado = Message::where('user_id', '=', $id);

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
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'Necesitas ser administrador para realizar esta acción.',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
