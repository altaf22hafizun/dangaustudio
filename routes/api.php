<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KaryaController;
use App\Http\Controllers\PameranController;
use App\Http\Controllers\SenimanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/events', EventController::class, array('as' => 'api'));
Route::apiResource('/seniman', SenimanController::class, array('as' => 'api'));
Route::apiResource('/berita', BeritaController::class, array('as' => 'api'));
Route::apiResource('/karya', KaryaController::class, array('as' => 'api'));
Route::apiResource('/pameran', PameranController::class, array('as' => 'api'));

Route::post('/midtrans-callback', [DetailController::class, 'callback']);
