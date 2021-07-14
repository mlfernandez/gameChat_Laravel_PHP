<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
            $user = auth()->user()->find($id);
            if(!$user){
                return response() ->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 400);
            }
            return response() ->json([
                'success' => true,
                'data' => $user,
            ], 200);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        {
            $user = auth()->user()->find($id);
            if(!$user){
                return response() ->json([
                    'success' => false,
                    'message' => 'Usario no encontrado',
                ], 400);
            }    
            $updated = $user->update([
                'username' => $request->input('username'),
                'streamUsername' => $request->input('streamUsername'),
                'email' => $request->input('email'),
            ]);
            if($updated){
                return response() ->json([
                    'success' => true,
                ]);
            } else {
                return response() ->json([
                    'success' => false,
                    'message' => 'El usuario no se puede actualizar',
                ], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = auth()->user()->find($id);

        $user->delete();
    }
}
