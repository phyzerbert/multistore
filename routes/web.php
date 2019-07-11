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

Route::get('lang/{locale}', 'VerifyController@lang')->name('lang');
Route::get('/verify', 'VerifyController@show')->name('verify');
Route::post('/verify', 'VerifyController@verify')->name('verify');

Route::any('/home', 'HomeController@index')->name('home');

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

// ******** Settings *************

Route::get('/company/index', 'CompanyController@index')->name('company.index');
Route::post('/company/create', 'CompanyController@create')->name('company.create');
Route::post('/company/edit', 'CompanyController@edit')->name('company.edit');
Route::get('/company/delete/{id}', 'CompanyController@delete')->name('company.delete');


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

Route::any('/purchase/index', 'PurchaseController@index')->name('purchase.index');
Route::get('/purchase/create', 'PurchaseController@create')->name('purchase.create');
Route::post('/purchase/save', 'PurchaseController@save')->name('purchase.save');
Route::get('/purchase/edit/{id}', 'PurchaseController@edit')->name('purchase.edit');
Route::post('/purchase/update', 'PurchaseController@update')->name('purchase.update');
Route::get('/purchase/detail/{id}', 'PurchaseController@detail')->name('purchase.detail');
Route::get('/purchase/delete/{id}', 'PurchaseController@delete')->name('purchase.delete');



Route::any('/sale/index', 'SaleController@index')->name('sale.index');
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

// ******** Report ********

Route::get('/report/overview_chart', 'ReportController@overview_chart')->name('report.overview_chart');
Route::any('/report/company_chart', 'ReportController@company_chart')->name('report.company_chart');
Route::get('/report/store_chart', 'ReportController@store_chart')->name('report.store_chart');
Route::get('/report/product_quantity_alert', 'ReportController@product_quantity_alert')->name('report.product_quantity_alert');
Route::get('/report/product_expiry_alert', 'ReportController@product_expiry_alert')->name('report.product_expiry_alert');
Route::get('/report/products_report', 'ReportController@products_report')->name('report.products_report');
Route::get('/report/categories_report', 'ReportController@categories_report')->name('report.categories_report');
Route::any('/report/sales_report', 'ReportController@sales_report')->name('report.sales_report');
Route::any('/report/purchases_report', 'ReportController@purchases_report')->name('report.purchases_report');
Route::get('/report/daily_sales', 'ReportController@daily_sales')->name('report.daily_sales');
Route::get('/report/monthly_sales', 'ReportController@monthly_sales')->name('report.monthly_sales');
Route::get('/report/payments_report', 'ReportController@payments_report')->name('report.payments_report');
Route::get('/report/customers_report', 'ReportController@customers_report')->name('report.customers_report');
Route::get('/report/suppliers_report', 'ReportController@suppliers_report')->name('report.suppliers_report');
Route::get('/report/users_report', 'ReportController@users_report')->name('report.users_report');


Route::post('/set_pagesize', 'HomeController@set_pagesize')->name('set_pagesize');
