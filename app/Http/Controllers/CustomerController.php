<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\CreateCustomerRequest;
use Illuminate\Auth\Middleware\Auth;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
        if($search = \Request::get('q')) 
        {
            $customers = Customer::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('email','LIKE',"%$search%");
            })->paginate(20);

        }else{
            $customers = Customer::latest()->paginate(15);
        }

        return response()->json($customers, 200);
    }
    /**
     * [show description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        return response()->json([
            "customer" => $customer
        ], 200);
    }

    /**
     * [create description]
     * @param  CreateCustomerRequest $request [description]
     * @return [type]                         [description]
     */
    public function create(Request $request)
    {
        $this->validate($request,[
            'name'      => 'required|string|max:191',
            'email'     => 'sometimes|string|email|max:191|unique:customers',
            'phone'     => 'required',
        ]);
        $customer = Customer::create([
            'name'          => $request['name'],
            'email'         => $request['email'],
            'phone'         => $request['phone'],
            'address'       => $request['address'],
            'birthday'      => $request['birthday'],
        ]);
        return response()->json([
            "customer" => $customer
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

        $customer = Customer::findOrFail($id);

        $this->validate($request,[
            'name'      => 'required|string|max:191',
            'email'     => 'sometimes|string|email|max:255|unique:customers,email,'.$customer->id,
            'phone'     => 'required',
        ]);

        $customer->update($request->all());

        return response()->json([
            "customer" => $customer
        ], 200);
    }
    /**
     * [delete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete(); 

        return response()->json([
            'message' => 'User Deleted'
        ], 200);
    }
    /**
     * [search description]
     * @return [type] [description]
     */
    public function search()
    {
        if($search = \Request::get('q')) 
        {
            $customers = Customer::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('email','LIKE',"%$search%");
            })->paginate(20);

        }else{
            $customers = Customer::latest()->paginate(5);
        }

        return response()->json($customers, 200);
    }
}