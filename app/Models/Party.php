<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
        // use HasFactory;

        protected $fillable = [
            'nombre', 'game_id'
        ];

        // Define la relacion de una party puede tener muchos mensajes
        public function message (){
            return $this -> hasMany(Message::class);
        }

        // Define la relacion de una party pertenece a un game
        public function game (){
            return $this -> belongsTo(Game::class);
        }

        // Define la relacion una party puede estar en muchas party-users
        public function party_user (){
            return $this -> hasMany(Party_User::class);
        }
}
