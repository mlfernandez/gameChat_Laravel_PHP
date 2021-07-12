<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
        use HasFactory;

        protected $fillable = [
            'text'
        ];

        // Define la relacion de un mensaje pertenece a un user
        public function user (){
            return $this -> belongsTo(User::class);
        }

        // Define la relacion de un mensaje pertenece a una party
        public function party (){
            return $this -> belongsTo(Party::class);
        }

}
