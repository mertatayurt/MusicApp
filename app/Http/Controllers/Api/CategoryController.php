<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Category;

class CategoryController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/getCategories",
     *     tags={"api"},
     *     operationId="getCategories",
     *     summary="List Song Categories",
     *     description="Expected Response : Json Array",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *
     *     @SWG\Response(
     *         response=400,
     *         description="Bad Request",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful Operation",
     *     ),
     *   security={{
     *     "Bearer":{}
     *   }}
     *
     * )
     */
    public function getCategories()
    {
        $data = Category::select('cat_name','cat_image','cat_description')->get();

        return response()->json($data,200);
    }

}