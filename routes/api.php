<?php

use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\FACILITY\BidController;
use App\Http\Controllers\Api\ReservationController;
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

    Route::post('createAde',[adsController::class,'createAds']);

    Route::get('get_ads',[adsController::class,'getAds']);

    Route::put('edit-ade/{id}',[adsController::class,'editAds']);

    Route::delete('remove_ade/{id}',[adsController::class,'removeAds']);

});

Route::group(['middleware' => ['auth:sanctum','IsClient']], function () {

    Route::post('create_reserve',[ReservationController::class,'createReserve']);
    Route::get('get_reserves',[ReservationController::class,'getreserves']);
    Route::put('edit_reserve/{id}',[ReservationController::class,'edit_reserve']);
    Route::delete('delete_reserve/{id}',[ReservationController::class,'remove_reserve']);


});

############## FACILITY ROUTES ******************
Route::group(['middleware' => ['auth:sanctum','IsFacility']], function () {

    Route::post('createBid',[BidController::class,'create_bid']);
    Route::get('getBids',[BidController::class,'get_bids']);
    Route::put('editBid/{id}',[BidController::class,'edit_bid']);
    Route::delete('/removeBid/{id}',[BidController::class,'remove_bids']);

});

Route::group(['middleware' => ['auth:owners']], function () {



});


