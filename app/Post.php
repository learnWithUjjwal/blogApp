<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Comment;

class Post extends Model
{
    //Table Name
    protected $table = "posts";
    //Change Primary key
    protected $primaryKey = "id";
    //Timestamps
    protected $timeStamp = true;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function comments(){
        return $this -> hasMany('App\Comment');
    }
}
