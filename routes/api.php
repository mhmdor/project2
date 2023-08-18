<?php

use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\ComplainController;
use App\Http\Controllers\Api\FACILITY\BidController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\OWNER\CategoryController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\TOURISM\adsController;
use App\Http\Controllers\Api\TOURISM\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/owner_login', [AuthController::class, 'ownerLogin']);


############## COMPLAINTS ROUTES ******************
Route::post('create_complaint',[ComplainController::class,'createComplain']);
Route::get('show_complaint/{id}',[ComplainController::class,'showComplaint']);
Route::get('UnRead_complaint',[ComplainController::class,'UnReadCOMP']);
Route::get('Read_complaint',[ComplainController::class,'ReadCOMP']);




Route::group(['middleware' => ['auth:sanctum','isTourism']], function () {

    ###Ads

    Route::post('createAde',[adsController::class,'createAds']);

    Route::get('get_ads',[adsController::class,'getAds']);

    Route::put('edit-ade/{id}',[adsController::class,'editAds']);

    Route::delete('remove_ade/{id}',[adsController::class,'removeAds']);

});

Route::group(['middleware' => ['auth:sanctum','IsClient']], function () {

  ############## RESERVATION ROUTES ******************
    Route::post('create_reserve',[ReservationController::class,'createReserve']);
    Route::get('get_reserves',[ReservationController::class,'getreserves']);
    Route::put('edit_reserve/{id}',[ReservationController::class,'edit_reserve']);
    Route::delete('delete_reserve/{id}',[ReservationController::class,'remove_reserve']);


    ############## FOLLOW ROUTES ******************
    Route::post('follow/{id}',[FollowController::class,'follow']);
    Route::delete('UNfollow/{id}',[FollowController::class,'UnFollow']);
    Route::get('get_specific_followers/{id}',[FollowController::class,'get_followers']);



});

############## FACILITY ROUTES ******************
Route::group(['middleware' => ['auth:sanctum','IsFacility']], function () {

    Route::post('createBid',[BidController::class,'create_bid']);
    Route::get('getBids',[BidController::class,'get_bids']);
    Route::put('editBid/{id}',[BidController::class,'edit_bid']);
    Route::delete('/removeBid/{id}',[BidController::class,'remove_bids']);

});

Route::group(['middleware' => ['auth:owners']], function () {

    Route::post('create_category',[CategoryController::class,'createCategory']);
    Route::get('get_category/{id}',[CategoryController::class,'getCategory']);
    Route::get('get_ALL_category',[CategoryController::class,'GetAllCategory']);
    Route::delete('remove_category/{id}',[CategoryController::class,'removeCategory']);
    Route::put('edit_category/{id}',[CategoryController::class,'EditCategory']);
    Route::post('owner_complaint/{id}',[ComplainController::class,'OWNER_READ']);
});


