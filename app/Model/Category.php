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

/**
 *  @SWG\Definition(definition="Category", type="object",
 *      @SWG\Property(property="cat_name",type="string"),
 *      @SWG\Property(property="cat_image",type="string"),
 *      @SWG\Property(property="cat_description",type="string")
 *  )
 */

class Category extends Model
{
    protected $table    = 'category';
    protected $fillable = ['cat_name','cat_image','cat_description'];
}
