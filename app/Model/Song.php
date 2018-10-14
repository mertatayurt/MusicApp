<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public $table    = 'song';
    protected $fillable = ['song_name','artist','cat_id'];
}
