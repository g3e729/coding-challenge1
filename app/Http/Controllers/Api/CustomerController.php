<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = (new \App\Services\CustomerService)->index();

        return response()->json($customers);
    }

    public function show(Customer $customer)
    {
        $customer = (new \App\Services\CustomerService)->show($customer);

        return response()->json($customer);
    }
}
