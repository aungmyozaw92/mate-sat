<?php

Route::post('v1/auth/login', 'Web\Api\v1\Auth\AuthController@login');

Route::group(['namespace' => 'Web\Api\v1', 'middleware' => 'auth:api', 'prefix' => 'v1'], function () {
    Route::get('auth/logout', 'Auth\AuthController@logout');
    Route::get('auth/profile', 'Auth\AuthController@profile');
    Route::post('auth/profile', 'Auth\AuthController@update_profile');
    Route::post('auth/check_password', 'Auth\AuthController@check_password');
    Route::post('auth/check_phone_no', 'Auth\AuthController@check_phone_no_valid');
    Route::get('get_master_records', 'HomeController@index');
    Route::get('dashboard', 'HomeController@dashboard_count');
    Route::get('clear_transaction', 'HomeController@clear_transaction');
   
    Route::apiResource('permissions', 'PermissionController')->except(['destroy']);
    Route::apiResource('roles', 'RoleController')->except(['destroy']);
   
    Route::apiResource('banks', 'BankController');
    Route::apiResource('bank_informations', 'BankInformationController')->except(['destroy']);
    Route::apiResource('users', 'UserController');
   
    Route::apiResource('cities', 'CityController');
    Route::apiResource('zones', 'ZoneController');
    Route::apiResource('departments', 'DepartmentController')->except(['destroy']);
   
    // CUstomer Management Route
    Route::get('customers/{customer}/orders', 'CustomerController@getOrders');
    Route::get('customers/{customer}/sales', 'CustomerController@getSales');
    Route::apiResource('customers', 'CustomerController');
   

    // Category Management Route
    Route::apiResource('categories', 'CategoryController');

    //Product Management Route
    Route::apiResource('products', 'ProductController');
    Route::post('products/{product}/update_image', 'ProductController@update_image');

    Route::apiResource('orders', 'OrderController');
    Route::get('orders/{order}/histories', 'OrderController@histories');
    Route::apiResource('order_items', 'OrderItemController');
   
    Route::apiResource('sales', 'SaleController');
    Route::post('sales/{sale}/create_payment', 'SaleController@create_sale_payment');

    Route::apiResource('bottle_returns', 'BottleReturnController')->except(['destroy','create']);

    //Report

    Route::get('daily_sales', 'SaleController@dailySales');
    
    
});
