<?php

use App\Integrations\Shipping\Shipment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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





Route::get('/bezz',function(){
    Shipment::make(2)->createShipment(Transaction::findOrfail(1));
    return 'test';
});


Route::get('/clear', function () {
    $exitCode = Artisan::call('optimize:clear');
    echo "<br/> done optimize clear";
    $exitCode = Artisan::call('cache:clear');
    echo "<br/> done cache clear";
    $exitCode = Artisan::call('config:clear');
    echo "<br/> done config clear";
    $exitCode = Artisan::call('route:clear');
    echo "<br/> done route clear";
    $exitCode = Artisan::call('view:clear');
    echo "<br/> done view clear";
    echo "<br/> <h1>done All clear</h1>";
});

Route::get('/{view}','HomeController@index');
