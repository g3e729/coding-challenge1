<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	print '<h2>Command</h2> <br/>';
	print 'php artisan command:retrieve_users <br/>';
	print '<br/>';
	print '<h2>API</h2> <br/>';
	print route('api.customer.index') . '<br/>';
	print route('api.customer.show', 1) . '<br/>';
	print '<br/>';
});

Route::get('customers', 'Api\CustomerController@index')->name('api.customer.index');
Route::get('customers/{customer}', 'Api\CustomerController@show')->name('api.customer.show');
