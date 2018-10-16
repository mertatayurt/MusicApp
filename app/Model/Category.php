<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
/**
 * Class Category
 *
 * @package App
 * @property string $cat_name
 * @property string $cat_image
 * @property integer $cat_description
 */
class Category extends Model
{
    protected $table    = 'category';
    protected $fillable = ['cat_name','cat_image','cat_description'];
}
