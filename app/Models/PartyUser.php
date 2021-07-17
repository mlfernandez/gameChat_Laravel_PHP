<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'party_id'
    ];

    // Define la relacion de una party-user pertenece a un user
    public function user (){
        return $this -> belongsTo(User::class);
    }

    // Define la relacion de user pertenece a una party-user
    public function party (){
        return $this -> belongsTo(Party::class);
    }
}
