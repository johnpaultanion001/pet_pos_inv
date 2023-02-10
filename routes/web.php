<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth as Login;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/product/filter', 'HomeController@filter')->name('filter');


Auth::routes();
Route::get('/google/login', [Login\LoginController::class, 'googleLogin'])->name('googleLogin');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    // Dashboard
    Route::get('dashboard', 'HomeController@index')->name('dashboard');

    // Inventories
    Route::resource('products', 'ProductController');
    Route::post('products/update/{product}', 'ProductController@updateproduct')->name('products.updateproduct');
    Route::post('products/stock/{product}', 'ProductController@addedstock')->name('products.addedproduct');

    // Orders
    Route::get('orders', 'OrderController@orders')->name('orders');

    // Change Status
    Route::put('orders/status/{order}', 'OrderController@status')->name('orders.status');

    // receipt
    Route::get('orders/receipt/{order}', 'OrderController@receipt')->name('orders.receipt');

    // Sales Reports
    Route::get('sales_reports/{filter}/{from}/{to}', 'OrderController@sales_reports')->name('sales_reports');
    

     // CustomerList
     Route::get('customer_list', 'CustomerListController@index')->name('customer');
     Route::get('customer_list/{user}/edit', 'CustomerListController@edit')->name('customer.edit');
     Route::put('customer_list/{user}', 'CustomerListController@update')->name('customer.update');
     Route::put('customer_list/{user}/dpass', 'CustomerListController@defaultPassowrd')->name('customer.dpass');

     // Admin List
     Route::get('admin_list', 'CustomerListController@admin_index')->name('admin');
     Route::post('admin_list', 'CustomerListController@admin_store')->name('admin.store');
     Route::put('admin_list/{admin}', 'CustomerListController@admin_update')->name('admin.update');

     // Change Status
     Route::put('customer/status/{user}', 'CustomerListController@status')->name('customer.status');
    
     // Categories
     Route::resource('categories', 'CategoryController');
});


Route::group(['prefix' => 'customer', 'as' => 'customer.', 'namespace' => 'Customer', 'middleware' => ['auth']], function () {
    
    // ORDERS
    Route::get('product/{product}', 'OrderController@view')->name('product.view');
    Route::post('product/{product}', 'OrderController@order')->name('product.order');
    Route::get('orders', 'OrderController@orders')->name('orders.index');
    Route::get('orders/{order}/edit', 'OrderController@edit')->name('order.edit');
    Route::put('orders/{order}', 'OrderController@update')->name('order.update');
    Route::delete('orders/{order}', 'OrderController@cancel')->name('order.cancel');
    Route::get('orders/checkout', 'OrderController@checkout')->name('order.checkout');

    // ORDER HISTORY
    Route::get('orders_history', 'OrderController@orders_history')->name('orders.history');
    Route::post('orders/cancel/{order}', 'OrderController@cancel_order')->name('orders.cancel');

    // ACCOUNT
    Route::get('account', 'HomeController@account')->name('account');
    Route::put('account', 'HomeController@account_update')->name('account.update');
    Route::put('account/change_password/{user}', 'HomeController@passwordupdate')->name('account.passwordupdate');

    // REVIEW ORDER HISTORY
    // STORE REVIEW
    Route::get('review', 'ReviewController@review')->name('review.review');

    // POST
    Route::get('posts', 'PostController@index')->name('post.index');
    Route::delete('posts/{post}', 'PostController@destroy')->name('post.destroy');
    Route::post('posts_store', 'PostController@store')->name('post.store');
    Route::get('comments', 'CommentController@store')->name('comment.store');
    Route::delete('comments/{comment}', 'CommentController@destroy')->name('comment.destroy');
   
});