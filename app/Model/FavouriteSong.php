<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
/**
 *  @SWG\Definition(definition="FavouriteSong", type="object",
 *      @SWG\Property(property="song_id",type="integer"),
 *      @SWG\Property(property="user_id",type="integer")
 *  )
 */
class FavouriteSong extends Model
{
    protected $table        = 'favourite_song';
    protected $fillable     = ['song_id','user_id'];
    public $timestamps      = false;
}
