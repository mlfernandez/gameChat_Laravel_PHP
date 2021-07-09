<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
        // use HasFactory;
        public function message (){
            return $this -> hasMany(Message::class);
        }

        public function game (){
            return $this -> belongsTo(Game::class);
        }

        public function party_user (){
            return $this -> hasMany(Party_User::class);
        }
}
