<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Godot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category(){
        // hasOne, hasMany, belongsTo, belongsToMany --> relationships
        return $this->belongsTo(User::class); // one godot BELONGS to only ONE user(its initiator)

    }
}
