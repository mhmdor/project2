<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TOURISM\adeController;
use App\Http\Controllers\Api\FACILITY\BidController;
use App\Http\Controllers\Api\TOURISM\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::post('createTrip', [TripController::class, 'createTrip']);



Route::post('/owner/login', [AuthController::class, 'ownerLogin']);

Route::group(['middleware' => ['auth:sanctum','isTourism']], function () {

    Route::post('createAde',[adeController::class,'create_Ade']);
    Route::get('get_ads',[adeController::class,'get_ads']);
    Route::put('edit-ade/{id}',[adeController::class,'edit_ade']);
    Route::get('test',[adeController::class,'test']);
    Route::delete('remove_ade/{id}',[adeController::class,'remove_ade']);

});

Route::group(['middleware' => ['auth:sanctum','IsClient']], function () {
});

Route::group(['middleware' => ['auth:sanctum','IsFacility']], function () {

    Route::post('create-bid',[BidController::class,'create_bid']);
    Route::get('bids',[BidController::class,'get_bids']);
    Route::put('edit-bid/{id}',[BidController::class,'edit_bid']);
    Route::delete('/remove-bids/{id}',[BidController::class,'remove_bids']);

});

Route::group(['middleware' => ['auth:owners']], function () {



});


