<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\CreateCustomerRequest;
use Illuminate\Auth\Middleware\Auth;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function all()
    {
        $customers = Customer::all();

        return response()->json([
            "customers" => $customers
        ], 200);
    }

    public function show($id)
    {
        $customer = Customer::whereId($id)->first();

        return response()->json([
            "customer" => $customer
        ], 200);
    }

    public function create(CreateCustomerRequest $request)
    {
        $customer = Customer::create($request->only($this->data()));

        return response()->json([
            "customer" => $customer
        ], 200);
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->only($this->data()));
        return $customer->toJson();
    }

    public function delete(Customer $customer)
    {
        $customer->delete();
    }

    private function data()
    {
        return [
            'first_name',
            'last_name',
            'email',
            'phone',
        ];
    }
}