<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QnaController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\BlogPostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HelpdeskController;
use App\Http\Controllers\Api\CashWithdrawController;
use App\Http\Controllers\Api\StaticContentController;
use App\Http\Controllers\Api\FavoriteProductController;
use App\Http\Controllers\Api\ShippingMethodController;
use App\Http\Controllers\Vendor\ImageController;
use App\Http\Controllers\Webhooks\TorodWebhookController;
use App\Http\Controllers\Webhooks\UpdateBezzShipmentWebhook;
use App\Http\Controllers\Webhooks\UpdateBezzWarehouseQnttWebhook;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group([
    'middleware' => 'api','prefix' => 'auth'
    ], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('generate-code', 'AuthController@generateCode');
    Route::post('register', 'AuthController@register');
    Route::post('update-profile', 'AuthController@updateProfile');
    Route::get('profile', 'AuthController@profile');
    Route::post('logout', 'AuthController@logout');
    Route::post('update-language/{lang}', 'AuthController@updateLanguage');

});


Route::group(['middleware' => 'api','prefix' => 'cart'],function () {
    Route::post('edit', 'CartController@addOrEditProduct');
    Route::post('sync', 'CartController@syncCartWithLocal');
    Route::get('products', 'CartController@getVendorProducts')->name('products');
    Route::post('delete', 'CartController@deleteProduct');
    Route::post('summary', 'CartController@summary');
    Route::post('checkout', 'TransactionController@checkout');
    Route::post('pay-with-wallet', 'TransactionController@payWithWallet');
    Route::post('pay', 'TransactionController@pay');
    Route::get('pay-callback', 'TransactionController@pay_callback')->name('paymant-callback');

});

Route::group(['middleware' => 'api','prefix' => 'wallet'],function () {
    Route::get('total', 'WalletController@totalAmount');
    Route::get('total-withdraw', 'WalletController@totalWithdraw');
    Route::get('transactions', 'WalletController@getTransactions');
    Route::get('data', 'WalletController@walletData');
});

Route::group(['middleware' => 'api','prefix' => 'order'],function () {
    Route::get('my-orders', 'TransactionController@userOrders');
    Route::get('track-my-orders', 'TransactionController@trackUserOrders');
    Route::get('order-deatails/{transaction_id}', 'TransactionController@orderDetails');
    Route::get('order-rate/{transaction_id}', 'TransactionController@getOrderDetailsForRate');
    Route::post('save-order-rate/{transaction_id}', 'TransactionController@saveOrderRate');
    Route::post('reorder/{transaction_id}', 'CartController@reorder');
});

Route::group(['middleware' => 'api','prefix' => 'address'],function () {
    Route::get('', 'AddressController@currentUserAddresses');
    Route::get('/show/{id}', 'AddressController@show');
    Route::post('update', 'AddressController@update');
    Route::post('store', 'AddressController@store');
    Route::post('delete/{id}', 'AddressController@delete');
    Route::post('set-default/{id}', 'AddressController@setDefault');
    Route::get('/geo-data', 'AddressController@GeoData');
});

Route::group(['middleware' => 'api','prefix' => 'products'],function () {
    Route::get("", [ProductController::class, "index"]);
    Route::get("/category/{id}", [ProductController::class, "CategotyProducts"]);
    Route::get("/{id}", [ProductController::class, "show"]);
    Route::post("/add-review", [ProductController::class, "addReview"]);
});

Route::group(['middleware' => 'api','prefix' => 'favorite'],function () {
    Route::get("", [FavoriteProductController::class, "getFavorite"]);
    Route::post("/add", [FavoriteProductController::class, "addFavorite"]);
    Route::post("/delete/{id}", [FavoriteProductController::class, "deleteFavorite"]);
});

Route::group(['middleware' => 'api','prefix' => 'categories'],function () {
    Route::get("home", [CategoryController::class, "homePageCategory"]);
    Route::get("get_tree/{id}", [CategoryController::class, "getCategoryTreeAll"]);
    Route::get("parent/{id}", [CategoryController::class, "parent"]);
    Route::get("show/{id}", [CategoryController::class, "show"]);
    Route::get("products/{id}", [CategoryController::class, "getCategoryProductsAll"]);
});

Route::group(['middleware' => 'api','prefix' => 'qnas'],function () {
    Route::get("", [QnaController::class, "index"]);
    Route::get("/{id}", [QnaController::class, "show"]);
});

Route::group(['middleware' => 'api','prefix' => 'vendors'],function () {
    Route::get("", [VendorController::class, "index"]);
    Route::get("/products/{id}", [VendorController::class, "sortedProducts"]);
    Route::get("/{id}", [VendorController::class, "show"]);
});

Route::group(['middleware' => 'api','prefix' => 'help-desk'],function () {
    Route::post("contact_us", [HelpdeskController::class, "contact_us"]);
    Route::get("contact_us/info", [SettingController::class, "contactInfo"]); 
});

Route::group(['middleware' => 'api','prefix' => 'search'],function () {
    Route::get("", [SearchController::class, "globalSearch"]);
});

Route::group(['middleware' => 'api','prefix' => 'recipe'],function () {
    Route::get("",      [RecipeController::class, "index"]);
    Route::get("/{id}", [RecipeController::class, "show"]);
});

Route::group(['middleware' => 'api','prefix' => 'blog'],function () {
    Route::get("", [BlogPostController::class, "index"]);
    Route::get("/post/{id}", [BlogPostController::class, "show"]);
});

Route::group(['middleware' => 'api','prefix' => 'static'],function () {
    Route::get("/{type}", [StaticContentController::class, "index"]);
});

Route::group(['middleware' => 'api','prefix' => 'country'],function () {
    Route::get("/all", [CountryController::class, "index"]);
});

Route::group(['middleware' => 'api','prefix' => 'setting'],function () {
    Route::get("/home-page-slider", [SettingController::class, "homePageSlider"]);
    Route::get("/website-settings", [SettingController::class, "websiteSetting"]);
    Route::get("/main-data", [SettingController::class, "mainData"]);
});

// cm
Route::group(['middleware' => 'api','prefix' => 'cash-withdraw-request'],function () {
    Route::post("/", [CashWithdrawController::class, "store"]);
});

Route::group(['middleware' => 'api','prefix' => 'shipping'],function () {
    Route::Post("/methods", [ShippingMethodController::class, "getAvailableMethods"]);
});

Route::group(['middleware' => 'api','prefix' => 'webhooks'],function () {
    Route::post('torod', [TorodWebhookController::class, "updateStatus"]);
    Route::post('beez/update-shipment-status', [UpdateBezzShipmentWebhook::class, "updateStatus"]);
    Route::post('beez/update-warehouse-qnt', [UpdateBezzWarehouseQnttWebhook::class, "updateStatus"]);
});

Route::prefix('guest')
    ->as('guest.')
    ->controller(GuestController::class)
    ->group(function() {
        Route::post('token', 'generateToken')->name('get-token');
        Route::post('cart/edit', 'editCart')->name('cart.edit');
        Route::post('cart/delete', 'deleteCart')->name('cart.delete');
        Route::get('cart/products', 'cartProducts')->name('cart.products');        
    });

Route::get("banks", [BankController::class, "index"]);