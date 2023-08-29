<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\OrderController;
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
    Auth::routes();
    Route::get('password/send-code','Auth\ForgotPasswordController@showResetPasswordForm');
    Route::post('password/confirm-phone','Auth\ForgotPasswordController@confirmPhone')->name('password.confirm-phone');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::middleware(['vendor.auth'])->group(function () {

	Route::get('/', [App\Http\Controllers\Vendor\IndexController::class, 'index']);
	Route::get('/home', [App\Http\Controllers\Vendor\IndexController::class, 'index'])->name('index');

	Route::get('profile','ProfileController@show')->name('profile');
	Route::get('edit-profile','ProfileController@edit')->name('edit-profile');
	Route::post('update-vendor','ProfileController@updateVendor')->name('update-vendor');;
	Route::post('update-profile','ProfileController@update')->name('update-profile');;
	Route::post('change-password','ProfileController@changePassword')->name('change-password');;
	//resources
	Route::resource('products','ProductController')->middleware('vendor_permission:product');
	Route::resource('orders','OrderController')->middleware('vendor_permission:order');
	Route::get('orders/invoice/{order:id}', [OrderController::class,'invoice'])->name('orders.invoice');
	Route::get('orders/invoice-pdf/{order:id}', [OrderController::class,'invoicePdf'])->name('orders.pdf-invoice');	
	Route::resource('users','VendorUserController')->middleware('vendor_permission:user');
	Route::resource('roles','RoleController')->middleware('vendor_permission:role');
	Route::resource('certificates','CertificateController')->middleware('vendor_permission:certificate');
	
	Route::get('product-reviews','ProductReviewController@index')->name('product-reviews')->middleware('vendor_permission:review');
	Route::post('orders/multi-delete','OrderController@multiDelete')->name('orders.multi-delete');
	Route::get('get-category-by-parent-id','ProductController@getSubCategories')->name('get_sub_categories');
	Route::get('products-for-table','ProductController@productForTable')->name('products-for-table');
	Route::post('upload-image','ImageController@upload_product_images')->name('upload_product_images')->middleware('vendor_permission:product');



    // wherehouse requests
    Route::middleware(['vendor_permission:warehouse'])->group(function () {	
	    Route::get('warehouse-request/create','VendorWarehouseRequestController@create')->name('warhouse_request.create');
	    Route::post('warehouse-request/store','VendorWarehouseRequestController@store')->name('warhouse_request.store');
	    Route::get('warehouse-request','VendorWarehouseRequestController@index')->name('warhouse_request.index');
	    Route::get('warehouse-request/product/{id}','VendorWarehouseRequestController@showProducts')->name('warhouse_request.show-products');
	    Route::get('warehouse-request/{id}','VendorWarehouseRequestController@show')->name('warhouse_request.show');
    });

    Route::get('wallet','WalletController@show')->name('wallet')->middleware('is_vendor_owner');
});


//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
