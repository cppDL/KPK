<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
// use App\Http\Requests\StoreCustomerRequest;
// use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Customer::all();
    }

    /**
     * Store a newly created resource in storage.
     */

        // app/Http/Controllers/Api/V1/CustomerController.php
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->all());

        // Return the customer data as a JSON response, without using a resource
        return response()->json($customer, 201);  // 201 status code for successful creation
    }

    // public function store(StoreCustomerRequest $request)
    // {
    //     return new CustomerResource(Customer::create($request->all()));
    // }


    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
