<?php

use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\FACILITY\BidController;
use App\Http\Controllers\Api\TOURISM\adsController;
use App\Http\Controllers\Api\TOURISM\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Route::post('createTrip', [TripController::class, 'createTrip']);



Route::post('/owner/login', [AuthController::class, 'ownerLogin']);

Route::group(['middleware' => ['auth:sanctum','isTourism']], function () {

    ###Ads

    Route::post('createAds',[adsController::class,'createAds']);

    Route::get('getAds',[adsController::class,'getAds']);

    Route::put('editAds/{id}',[adsController::class,'editAds']);

    Route::delete('removeAds/{id}',[adsController::class,'removeAds']);

});

Route::group(['middleware' => ['auth:sanctum','IsClient']], function () {
});

Route::group(['middleware' => ['auth:sanctum','IsFacility']], function () {

    Route::post('createBid',[BidController::class,'create_bid']);
    Route::get('getBids',[BidController::class,'get_bids']);
    Route::put('editBid/{id}',[BidController::class,'edit_bid']);
    Route::delete('/removeBid/{id}',[BidController::class,'remove_bids']);

});

Route::group(['middleware' => ['auth:owners']], function () {



});


