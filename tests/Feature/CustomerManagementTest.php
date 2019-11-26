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
        ])->json('POST', route('customer.create'), $this->data());

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
        ])->json('GET',route('customer.all'));

        $response->assertStatus(200);

        $this->assertEquals(1,count($response->json()));
        $this->assertEquals('Sunnyboy Mathole',$response->json()['customers'][0]['name']);
    }

    /** @test */
    public function it_can_update_customer()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();
        $customer = Customer::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT',route('customer.update',['customer' => $customer->id]),
        array_merge($this->data(),['name' => 'Tumi Mathole']));

        $response->assertStatus(200);

        $this->assertEquals('Tumi Mathole', Customer::first()->name);
    }

    /** @test */
    public function it_can_show_customer()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();

        $customer = Customer::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',route('customer.show',['customer' => $customer->id]));

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
        ])->json('POST',route('customer.delete',['customer' => $customer->id]));

        $response->assertStatus(200);
        $this->assertEquals(0, Customer::count());
    }

    private function data()
    {
        return [
            'name'      => 'Sunnyboy Mathole',
            'email'     => 'Matholeas@gmail.com',
            'phone'     => '0718296512',
            'address'   =>'F304 Walmer Street Khayelitsha 7784',
            'birthday'  => '1987-10-22',
        ];
    }
}