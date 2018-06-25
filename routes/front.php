<?php

    Route::get('/','Front\HomeController@home');

    Route::get('product/{slug}','Front\ProductController@getProduct');
    Route::get('product-category/{slug}','Front\ProductController@getProductCategory');
    Route::get('product-details/{slug}','Front\ProductController@productDetails');

    Route::get('product-collection/{slug}','Front\ProductController@productCollection');

    Route::get('cart','Front\CartController@cart');

    Route::get('logout','Front\FrontUsersController@logout');
    Route::group(['middleware' => 'non_login_customer'], function() {

        Route::get('login-register','Front\FrontUsersController@index');
        Route::post('register','Front\FrontUsersController@register');
        Route::post('login','Front\FrontUsersController@login');

    });
    Route::get('ckeckout','Front\FrontUsersController@ckeckout');



//    Route::group(['middleware' => ['auth_customer','PageTitle']], function() {
//        /*  Customers routes */
//
//        Route::any('customer-dashboard', 'Front\CustomerController@index');
//
//        Route::get('logout', 'Front\CustomerController@logout');
//        Route::post('useremail-exists', 'Front\CustomerController@userEmailExists');
//
//
//    });
