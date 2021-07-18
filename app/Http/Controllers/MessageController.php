<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\PartyUser;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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
        // Postman: necesita "token" y "text", "party_id" por body
    public function store(Request $request)

    {
        $user = auth()->user();

        $this->validate( $request , [
            'text' => 'required',
            'party_id' => 'required',
        ]);

        // chequea si ya esta en la party
        $checkUserInParty = PartyUser::where('party_id','=', $request->party_id)->where('user_id', '=', $user->id)->get();

        if ($checkUserInParty->isEmpty()) {

            return response() ->json([
                'success' => false,
                'message' => 'El usuario no esta en esa party',
            ], 400);

        } else {
            $message = Message::create ([
                    'text' => $request -> text,
                    'user_id' => $user->id,
                    'party_id' => $request -> party_id,
                ]);

            if ($message) {
            
            return response() ->json([
                'success' => true,
                'message' => "Mensaje enviado"
            ], 200);

            } else { 
                return response()->json([
                    'success' => false,
                    'message' => "No se pudo enviar el mensaje"
                ], 400); 

            }
        }     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */

        // ruta busca todos los messages
        // GET https://gamechat-laravel-mlf.herokuapp.com/api/messages
        // Postman: necestia "token" del admin (id 15 Mariana)
    public function show()
    {
        $user = auth()->user();

        $messages = Message::all();

        if($user->id === 15){

            return response() ->json([
                'success' => true,
                'data' => $messages,
            ]);

        } else {

            return response() ->json([
                'success' => false,
                'message' => 'No tienes permiso para realizar esta acción.',
            ], 400);

        }
    }

        // ruta busca messages por id de usuario
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/messages/showByUserId
        // Postman: necestia "token" y se pasa id por url
    public function showByUserId(Request $request)
    {
        $user = auth()->user();

        if($user->id == $request->user_id){
            
            $message = Message::where('user_id', '=', $request->user_id)->get();

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
                'message' => 'Necesitas ser el usuario creador para realizar esta acción.',
            ], 400);
    
        }
    }

        // ruta busca messages por id de party
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/messages/showByPartyId
        // Postman: necestia "token" y se pasa party_id por body , el usuario que busca tiene que estar en la party
    public function showByPartyId(Request $request)
    {
        $user = auth()->user();
        

        // chequea si ya esta en la party
        $checkUserInParty = PartyUser::where('party_id','=', $request->party_id)->where('user_id', '=', $user->id)->get();

        if ($checkUserInParty->isEmpty()) {

            return response() ->json([
                'success' => false,
                'message' => 'El usuario no esta en esa party',
            ], 400);

        } else {

            $message = Message::where('party_id', '=', $request->party_id)->get();

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
        $request->validate([
            'text' => 'required|string|min:1',
        ]);
        $user = $request->user();
        $message = Message::find($id);
        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => "El mensaje no existe."
            ], 400);
        }
        if ($message['user_id'] != $user['id']) {
            return response()->json([
                'success' => false,
                'message' => "El mensaje no te pertenece."
            ], 400);
        }
        try {
            return $message->update([
                "text" => $request->text,
                "edited" => true,
                "success" => true,
                'message' => "El mensaje se ha actualizado correctamente"
            ]);
        } catch(QueryException $error) {
             return $error;
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
