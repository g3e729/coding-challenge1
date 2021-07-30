<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function index()
    {

        $customers = \App\Models\Customer::get()
            ->makeVisible(['country'])
            ->append(['email', 'full_name']);

        return $customers->toArray();
    }

    public function show(Customer $customer)
    {
        $customer->makeVisible(['city', 'country', 'gender', 'phone'])
        ->append(['email', 'full_name', 'username']);

        return $customer->toArray();
    }
}