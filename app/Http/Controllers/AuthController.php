<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if($token = $this->guard('api')->attempt($credentials)) 
        {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:6',
        ]);   

        if ($validator->fails()) 
        {          
            return response()->json(
                ['error'=>$validator->errors()], 401
            );
        }

        $input = $request->all();  
        $input['password']  = Hash::make($request->get('password'));
        $user               = User::create($input); 
        $access_token       = JWTAuth::fromUser($user);

        return response()->json(compact('access_token'), 200); 
    }
    public function me()
    {
        return response()->json($this->guard('api')->user());
    }

    public function logout()
    {
        $this->guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token'  => $token,
            'user'          => $this->guard()->user(),
            'token_type'    => 'bearer',
            'expires_in'    => $this->guard('api')->factory()->getTTL() * 60 * 60
        ]);
    }

    public function guard()
    {
        return \Auth::Guard('api');
    }
}
