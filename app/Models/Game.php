<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
        use HasFactory;

        protected $fillable = [
            'title', 'images', 'url'
        ];

        // Define la relacion de un game puede estar en muchas partys
        public function party (){
            return $this -> hasMany(Party::class);
        }
}
