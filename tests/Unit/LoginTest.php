<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_be_registered()
    {
        $this->withoutExceptionHandling();

        $response = $this->json('post', route('api.register'), $this->data());

        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token',$response->json());
    }

    /** @test */
    public function a_user_can_login_with_token()
    {
        $this->withoutExceptionHandling();

        $user = User::create(array_merge($this->data(),
                                        ['password' =>Hash::make('secret1234')]));

        $this->assertCount(1, User::all());

        $response = $this->json('post', route('api.authenticate'),[
            'email'     => 'test@gmail.com',
            'password'  => 'secret1234',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token',$response->json());
    }

    private function data()
    {
        return [
            'name'                  => 'Test User',
            'email'                 => 'test@gmail.com',
            'password'              => 'secret1234',
            'password_confirmation' => 'secret1234',
        ];
    }
}
