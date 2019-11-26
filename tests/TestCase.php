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
            'name'          => 'Test User',
            'email'         => 'Matholeadds@gmail.com',
            'password'      => Hash::make('secret1234'),
            'role'          => 'Admin',
            'status'        => 'InActive',
            'bio'           => "Neon tube-space plastic media-ware augmented reality boat woman. Geodesic assault decay numinous Shibuya drugs carbon stimulate franchise boat claymore mine. Nodal point saturation point pistol meta-numinous-ware boy modem sensory faded kanji 8-bit neon film advert j-pop pre.",
            'photo'         => '.jpg',
        ]);
        $token = JWTAuth::fromUser($user);
        return $token;
    }
}
