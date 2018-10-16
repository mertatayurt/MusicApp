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
class Song extends Model
{
    public $table    = 'song';
    protected $fillable = ['song_name','artist','cat_id'];
}
