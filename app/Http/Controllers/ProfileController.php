<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Middleware\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function profile()
    {
        return auth('api')->user();
    }

    public function update(Request $request)
    {
        $user = auth('api')->user();

        $this->validate($request,[
            'name'      => 'required|string|max:191',
            'email'     => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password'  => 'sometimes|required|min:6',
        ]);

        $currentPhoto = $user->photo;

        if($request->photo != $currentPhoto){

            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            $request->merge(['photo' => $name]);

            $userPhoto = public_path('img/profile/').$currentPhoto;

            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }

        if(!empty($request->password))
        {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());

        return ['message' => "Success"];
    }
}