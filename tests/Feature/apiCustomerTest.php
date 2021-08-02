<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class apiCustomerTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test **/
    public function getCustomers()
    {
        $response = $this->get('/customers');

        $response->assertStatus(200);
    }

    /** @test **/
    public function getCustomer()
    {
        $customer = Customer::get()->shuffle()->first();
        $response = $this->get('/customers/' . $customer->id);

        $response->assertJsonFragment(['full_name' => $customer->full_name]);
    }
}
