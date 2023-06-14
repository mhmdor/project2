<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TOURISM\testControoler;
use App\Http\Controllers\Api\TOURISM\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('createTrip', [TripController::class, 'createTrip']);
Route::post('create', [testControoler::class, 'createTrip']);
Route::get('t',function (){
    echo "hello world";
});
