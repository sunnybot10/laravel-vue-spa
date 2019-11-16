<?php

namespace Tests\Unit;

use App\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_customer()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('post', route('customer.create'), $this->data());

        $response->assertStatus(200);
        $count = Customer::where('email','Matholeas@gmail.com')->first()->count();
        $this->assertEquals(1,$count);
    }

    /** @test */
    public function it_can_get_all_customers()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();
        $customer = Customer::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('get',route('customer.all'));

        $response->assertStatus(200);

        $this->assertEquals(1,count($response->json()));
        $this->assertEquals('Sunnyboy',$response->json()['customers'][0]['first_name']);
    }

    /** @test */
    public function it_can_update_customer()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();
        $customer = Customer::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('post',route('customer.update',['customer' => $customer->id]),
        ['first_name' => 'Tumi']);

        $response->assertStatus(200);

        $this->assertEquals('Tumi', Customer::first()->first_name);
    }

    /** @test */
    public function it_can_show_customer()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();

        $customer = Customer::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('get',route('customer.show',['customer' => $customer->id]));

        $response->assertStatus(200);

        $this->assertEquals('Matholeas@gmail.com',$response->json()['customer']['email']);
    }

    /** @test */
    public function it_can_delete_customer()
    {
        $token = $this->authenticate();

        $customer = Customer::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('post',route('customer.delete',['customer' => $customer->id]));

        $response->assertStatus(200);
        $this->assertEquals(0, Customer::count());
    }

    private function data()
    {
        return [
            'first_name'    => 'Sunnyboy',
            'last_name'     => 'Mathole',
            'email'         => 'Matholeas@gmail.com',
            'phone'         => '0718296512',
        ];
    }
}