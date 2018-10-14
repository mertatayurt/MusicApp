<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FavouriteSong extends Model
{
    protected $table        = 'favourite_song';
    protected $fillable     = ['song_id','user_id'];
    public $timestamps      = false;
}
