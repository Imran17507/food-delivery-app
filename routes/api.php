<?php

use App\Http\Controllers\Api\NearestRiderController;
use App\Http\Controllers\Api\RiderLocationHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/rider/location-history', [RiderLocationHistoryController::class, 'store']);
Route::post('/restaurant/nearest-rider', [NearestRiderController::class, 'nearestRider']);
