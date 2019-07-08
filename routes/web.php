<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/updateuser', 'UserController@updateuser')->name('updateuser');
Route::get('/users/index', 'UserController@index')->name('users.index');
Route::post('/user/create', 'UserController@create')->name('user.create');
Route::post('/user/edit', 'UserController@edituser')->name('user.edit');
Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete');

Route::get('/customer/index', 'CustomerController@index')->name('customer.index');
Route::post('/customer/create', 'CustomerController@create')->name('customer.create');
Route::post('/customer/edit', 'CustomerController@edit')->name('customer.edit');
Route::get('/customer/delete/{id}', 'CustomerController@delete')->name('customer.delete');

Route::get('/supplier/index', 'SupplierController@index')->name('supplier.index');
Route::post('/supplier/create', 'SupplierController@create')->name('supplier.create');
Route::post('/supplier/edit', 'SupplierController@edit')->name('supplier.edit');
Route::get('/supplier/delete/{id}', 'SupplierController@delete')->name('supplier.delete');



Route::get('/category/index', 'CategoryController@index')->name('category.index');
Route::post('/category/create', 'CategoryController@create')->name('category.create');
Route::post('/category/edit', 'CategoryController@edit')->name('category.edit');
Route::get('/category/delete/{id}', 'CategoryController@delete')->name('category.delete');

Route::get('/store/index', 'StoreController@index')->name('store.index');
Route::post('/store/create', 'StoreController@create')->name('store.create');
Route::post('/store/edit', 'StoreController@edit')->name('store.edit');
Route::get('/store/delete/{id}', 'StoreController@delete')->name('store.delete');


Route::get('/product/index', 'ProductController@index')->name('product.index');
Route::get('/product/create', 'ProductController@create')->name('product.create');
Route::post('/product/save', 'ProductController@save')->name('product.save');
Route::get('/product/edit/{id}', 'ProductController@edit')->name('product.edit');
Route::post('/product/update', 'ProductController@update')->name('product.update');
Route::get('/product/detail/{id}', 'ProductController@detail')->name('product.detail');
Route::get('/product/delete/{id}', 'ProductController@delete')->name('product.delete');

Route::get('/purchase/index', 'PurchaseController@index')->name('purchase.index');
Route::get('/purchase/create', 'PurchaseController@create')->name('purchase.create');
Route::post('/purchase/save', 'PurchaseController@save')->name('purchase.save');
Route::get('/purchase/edit/{id}', 'PurchaseController@edit')->name('purchase.edit');
Route::post('/purchase/update', 'PurchaseController@update')->name('purchase.update');
Route::get('/purchase/detail/{id}', 'PurchaseController@detail')->name('purchase.detail');
Route::get('/purchase/delete/{id}', 'PurchaseController@delete')->name('purchase.delete');



Route::get('/sale/index', 'SaleController@index')->name('sale.index');
Route::get('/sale/create', 'SaleController@create')->name('sale.create');
Route::post('/sale/save', 'SaleController@save')->name('sale.save');
Route::get('/sale/edit/{id}', 'SaleController@edit')->name('sale.edit');
Route::post('/sale/update', 'SaleController@update')->name('sale.update');
Route::get('/sale/detail/{id}', 'SaleController@detail')->name('sale.detail');
Route::get('/sale/delete/{id}', 'SaleController@delete')->name('sale.delete');


Route::get('/payment/index/{type}/{id}', 'PaymentController@index')->name('payment.index');
Route::post('/payment/create', 'PaymentController@create')->name('payment.create');
Route::post('/payment/edit', 'PaymentController@edit')->name('payment.edit');
Route::get('/payment/delete/{id}', 'PaymentController@delete')->name('payment.delete');

Route::get('get_products', 'VueController@get_products');
Route::post('get_orders', 'VueController@get_orders');
Route::post('get_product', 'VueController@get_product');
