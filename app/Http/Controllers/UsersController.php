<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{

	public function __construct()
    {
       
    }

    public function index()
    {
        $user = User::all();
        
        return response()->json([
            "users" => $user
        ], 200);
    }

    public function show($id)
    {
        $user = User::whereId($id)->first();

        return response()->json([
            "user" => $user
        ], 200);
    }

    public function store(CreateUserRequest $request)
    {
        $user = User::create($request);

        return response()->json([
            "user" => $user
        ], 200);
    }
}
