<?php

namespace App\Http\Controllers\Api\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public const appVersion         = "1.0";
    public const langFileVersion    = "1.0";

    /**
     * @SWG\Swagger(
     *   basePath="/api/v1",
     *   @SWG\Info(
     *     title="Music App API",
     *     version="1.0.0"
     *   ),
     *     schemes={"http"},
     *     @SWG\SecurityScheme(
     *         securityDefinition="Bearer",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header"
     *     ),
     *     )
     */

    private $client;

    private $id;

    public function __construct()
    {
        $this->client = Client::find(2);
    }

    /**
     * @SWG\Post(
     *     path="/auth/register",
     *     tags={"auth"},
     *     operationId="registerUser",
     *     summary="Registers user",
     *     description="",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     description="User Email.",
     *     required=true,
     *     type="string"
     *   ),
     *     @SWG\Parameter(
     *     name="password",
     *     in="formData",
     *     description="User Password.",
     *     required=true,
     *     type="string"
     *   ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad Request",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful Operation",
     *     ),
     *
     *
     * )
     */
    public function register (Request $request){
        $this->validate($request, [
            'email'              => 'required',
            'password'           => 'required|min:6'
        ]);
        $user = User::create([
            'email'     =>request('email'),
            'password'  =>bcrypt(request('password'))
        ]);

        $params = [
            'grant_type'    => 'password',
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret,
            'username'      => request('email'),
            'password'      => request('password'),
            'scope'         => '*'
        ];
        $request->request->add($params);
        $proxy = Request::create('oauth/token','POST');
        return Route::dispatch($proxy);
    }


    /**
     * @SWG\Post(
     *     path="/auth/login",
     *     tags={"auth"},
     *     operationId="loginUser",
     *     summary="Logs in user",
     *     description="",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *   @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     description="User Email.",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="password",
     *     in="formData",
     *     description="User Password.",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="appVersion",
     *     in="formData",
     *     description="App Version such as 1.0",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="langFileVersion",
     *     in="formData",
     *     description="Lang File Version such as 1.0",
     *     required=true,
     *     type="string"
     *   ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad Request",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful Operation",
     *     ),
     *
     *
     * )
     */
    public function login (Request $request){
        $this->validate($request, [
            'email'             => 'required',
            'password'          => 'required',
            'appVersion'        => 'required',
            'langFileVersion'   => 'required'
        ]);

        if($request->appVersion != self::appVersion || $request->langFileVersion != self::langFileVersion)
        {
            $data = ['status' => 'VersionFail', 'message' => 'Please update application !'];
            return response()->json($data,203);
        }

        $user = User::where('email',request('email'))->first();

        if(null !== $user)
        {
            $params = [
                'grant_type'    => 'password',
                'client_id'     => $this->client->id,
                'client_secret' => $this->client->secret,
                'username'      => request('email'),
                'password'      => request('password'),
                'scope'         => '*'
            ];
            $request->request->add($params);
            $proxy = Request::create('oauth/token','POST');
            return Route::dispatch($proxy);
        } elseif (null !== $user && $user->is_banned == 1){
            $data = ['status' => 'Error', 'message' => 'Disabled Account.'];
            return response()->json($data,203);
        }
        else {
            $data = ['status' => 'Error', 'message' => 'Invalid Credentials.'];
            return response()->json($data,203);
        }
    }

    public function refresh (Request $request){
        $this->validate($request, [
            'refresh_token'=> 'required'
        ]);
        $params = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => request('username'),
            'password' => request('password'),
            'scope' => '*'
        ];
        $request->request->add($params);
        $proxy = Request::create('oauth/token','POST');
        return Route::dispatch($proxy);
    }

    public function logout (Request $request)
    {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id',$accessToken->id)
            ->update(['revoked' => true]);
        $accessToken->revoke();
        return response()->json([],204);
    }
}
