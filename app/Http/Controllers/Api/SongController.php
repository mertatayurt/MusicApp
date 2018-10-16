<?php

namespace App\Http\Controllers\Api;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use App\Model\FavouriteSong;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * @SWG\Post(
     *     path="/getSongsByCategory",
     *     tags={"api"},
     *     operationId="getSongsByCategory",
     *     summary="Return songs by given category",
     *     description="Expected Response : Json Array",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     * @SWG\Parameter(
     *     name="cat_id",
     *     in="formData",
     *     description="Song Category Id",
     *     required=true,
     *     type="integer"
     * ),
     * @SWG\Response(
     *     response=400,
     *     description="Bad Request",
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Successful Operation",
     * ),
     *   security={{
     *     "Bearer":{}
     *   }}
     * )
     */
    public function getSongsByCategory(Request $request)
    {
        $this->validate($request, [
            'cat_id'     => 'required|min:1|max:2147483648|integer'
        ]);

        //Returns a list of songs, joins 'favouritesong' table by authenticated user
        $userId = Auth::id();

        $data = DB::table('song as t1')
            ->select('t1.id','t1.song_name','t1.artist',DB::raw('IF(t2.song_id is null,0,1) as is_favourite'))
            ->leftJoin('favourite_song as t2',function($join)use($userId) {
                $join->on('t1.id',      '=', 't2.song_id');
                $join->on('t2.user_id', '=', DB::raw($userId));
            })
            ->where('t1.cat_id',$request->cat_id)
            ->get();

        return response()->json($data,200);
    }

    /**
     * @SWG\Post(
     *     path="/upFavourite",
     *     tags={"api"},
     *     operationId="upFavourite",
     *     summary="Updates given status by authorized user",
     *     description="Expected Response : Json Status",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     * @SWG\Parameter(
     *     name="song_id",
     *     in="formData",
     *     description="Song Id",
     *     required=true,
     *     type="integer"
     * ),
     * @SWG\Parameter(
     *     name="status",
     *     in="formData",
     *     description="1 stands for add to favourites, 0 for delete.",
     *     required=true,
     *     type="integer"
     * ),
     * @SWG\Response(
     *     response=400,
     *     description="Bad Request",
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Successful Operation",
     * ),
     *   security={{
     *     "Bearer":{}
     *   }}
     * )
     */
    public function upFavourite(Request $request)
    {
        $this->validate($request, [
            'song_id'    => 'required|min:1|max:2147483648|integer',
            'status'     => 'required|min:0|max:1|integer'
        ]);

        if ($request->status == 0)
        {
            //Delete user favourite song record from table
            FavouriteSong::where('song_id',$request->song_id)
                ->where('user_id',Auth::id())
                ->delete();
            return response()->json(JsonResponse::response('success','User Favourite Deleted'),200);
        }
        else
        {
            $count = FavouriteSong::where('song_id',$request->song_id)->where('user_id',Auth::id())->count();
            if ($count > 0)
                return response()->json(JsonResponse::response('Fail','Already exist.'));

            $favSong = new FavouriteSong();

            $favSong->song_id = $request->song_id;
            $favSong->user_id = Auth::id();

            $favSong->save();

            return response()->json(JsonResponse::response('success','User Favourite Inserted'),200);
        }

    }
}