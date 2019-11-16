<?php

namespace Tests;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function authenticate()
    {
        $user = User::create([
            'name'                  => 'Test User',
            'email'                 => 'test@gmail.com',
            'password_confirmation' => 'secret1234',
            'password'              => Hash::make('secret1234'),
        ]);
        $token = JWTAuth::fromUser($user);
        return $token;
    }
}
