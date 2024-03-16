<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kendaraan;
use App\Http\Controllers\Transaksi;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('kendaraan')->group(function (){
    Route::get('/', [Kendaraan::class, 'getKendaraanList']);
    Route::patch('/stock', [Kendaraan::class, 'updateKendaraanStock']);
});

Route::prefix('transaction')->group(function(){
    Route::post('/', [Transaksi::class, 'insertTransaction']);
    Route::get('/', [Transaksi::class, 'getTransaction']);
    Route::get('/detail', [Transaksi::class, 'getTransactionDetail']);
    Route::get('/report', [Transaksi::class, 'getTransactionReport']);
});
