<?php

namespace App\Http\Controllers;

use App\Models\Party_User;
use Illuminate\Http\Request;

class Party_UserController extends Controller
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

            $party_user = Party_User::all();

            return response() ->json([
                'success' => true,
                'data' => $party_user,
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
    public function store(Request $request)
    {
        $user = auth()->user();

        $this->validate( $request , [
            'party_id' => 'required',
        ]);

        $party_user = Party_User::create ([
            'user_id' => $user -> id,
            'party_id' => $request -> party_id,
        ]);

        if ($party_user) {

            return response() ->json([
                'success' => true,
                'data' => $party_user
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
     * @param  \App\Models\Party_User  $party_User
     * @return \Illuminate\Http\Response
     */
    public function showByUser()
    {
        $user = auth()->user();

        $party_user = Party_User::where('user_id', '=', $user->id)->get();

        if($user->id){

            return response() ->json([
                'success' => true,
                'data' => $party_user,
            ]);

        } else {

            return response() ->json([
                'success' => false,
                'message' => 'No tienes permiso de administrador para realizar esta acción.',
            ], 400);

        }
    }

    public function showByParty(Request $request)
    {
        $user = auth()->user();

        $party_user = Party_User::where('party_id', '=',  $request -> party_id)->get();


        if($user->id){

            return response() ->json([
                'success' => true,
                'data' => $party_user,
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
     * @param  \App\Models\Party_User  $party_User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Party_User $party_User)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Party_User  $party_User
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party_User $party_User)
    {
        //
    }
}
