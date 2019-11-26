<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      
    }

    /**
     * [all description]
     * @return [type] [description]
     */
    public function all()
    {
        $user = User::latest()->paginate(10);

        return response()->json($user, 200);
    }

    /**
     * [show description]
     * 
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            "user" => $user
        ], 200);
    }

    /**
     * [create description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function create(Request $request)
    {
        $this->validate($request,[
            'name'      => 'required|string|max:191',
            'email'     => 'required|string|email|max:191|unique:users',
            'password'  => 'required|string|min:6',
            'role'      => 'required',
            'status'    => 'required',
        ]);
        $user = User::create([
            'name'      => $request['name'],
            'email'     => $request['email'],
            'password'  => Hash::make($request['password']),
            'role'      => $request['role'],
            'status'    => $request['status'],
            'bio'       => $request['bio'],
            'photo'     => $request['photo'],
        ]);
        return response()->json([
            "user" => $user
        ], 200);
    }
    
    /**
     * [update description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name'      => 'required|string|max:255',
            'email'     => 'sometimes|string|email|max:255|unique:users,email,'.$user->id,
            'password'  => 'sometimes|required|min:6',
        ]);

        $user->update($request->all());

        return response()->json([
            "user" => $user
        ], 200);
    }

    /**
     * [delete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => 'User Deleted'
        ], 200);
    }
}
