<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /*I want to make a sense out of all of this*/
    use HasFactory;

    private $one;
    protected $other;
    public $strange;

    /*Where to start?*/
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];



}
