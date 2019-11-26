<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * 
     * [it_can_create_user description]
     * @return [type] [description]
     */
    public function it_can_create_user()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST', route('user.create'), $this->data());

        $response->assertStatus(200);

        $count = User::where('email','Matholeas@gmail.com')->count();
        $this->assertEquals(1,$count);
    }

    /**
     * @test
     * 
     * [it_can_create_user description]
     * @return [type] [description]
     */
    public function it_can_get_all_users()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();
        $user = User::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',route('user.all'));

        $response->assertStatus(200);

        $this->assertEquals(1,count($response->json()));
        $this->assertEquals('Test User',$response->json()['user'][0]['name']);
    }

    /**
     * @test
     * 
     * [it_can_create_user description]
     * @return [type] [description]
     */
    public function it_can_update_user()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();

        $user = User::create($this->data());
       
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT',route('user.update',['user' => $user->id]),
        array_merge($this->data(),['email' => 'Agreetumi@gmail.com']));

        $response->assertStatus(200);

        $this->assertEquals('Agreetumi@gmail.com', $response->json()['user']['email']);
    }

    /**
     * @test
     * 
     * [it_can_create_user description]
     * @return [type] [description]
     */
    public function it_can_show_user()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();

        $user = User::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',route('user.show',['user' => $user->id]));

        $response->assertStatus(200);

        $this->assertEquals('Matholeas@gmail.com',$response->json()['user']['email']);
    }

    /**
     * @test
     * 
     * [it_can_create_user description]
     * @return [type] [description]
     */
    public function it_can_delete_user()
    {
        $token = $this->authenticate();

        $user = User::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST',route('user.delete',['user' => $user->id]));

        $response->assertStatus(200);
    }
    /**
     * 
     */
    private function data()
    {
        return [
            'name'          => 'Test User',
            'email'         => 'Matholeas@gmail.com',
            'password'      => 'secret1234',
            'role'          => 'Admin',
            'status'        => 'InActive',
            'bio'           => 'Lorem IpsumSoul-delay semiotics corporation stimulate claymore mine computer urban silent garage. Chrome rain fetishism youtube papier-mache math-sprawl saturation point stimulate post-tanto drugs. Lights hotdog tanto euro-pop motion singularity advert tube. Sensory bridge drugs San Francisco render-farm sign shrine concrete computer narrative.',
            'photo'         => 'riflechiba.jpg',
        ];
    }
}