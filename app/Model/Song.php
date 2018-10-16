<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
/**
 * Class Song
 *
 * @package App
 * @property string $song_name
 * @property string $artist
 * @property integer $cat_id
 */

/**
 *  @SWG\Definition(definition="Song", type="object",
 *      @SWG\Property(property="song_name",type="string"),
 *      @SWG\Property(property="artist",type="string"),
 *      @SWG\Property(property="cat_id",type="integer")
 *  )
 */


class Song extends Model
{
    public $table    = 'song';
    protected $fillable = ['song_name','artist','cat_id'];
}
