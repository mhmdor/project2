<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/owner/login', [AuthController::class, 'ownerLogin']);

Route::group(['middleware' => ['auth:sanctum','isTourism']], function () {

 
   
});

Route::group(['middleware' => ['auth:sanctum','IsClient']], function () {

 
 

});

Route::group(['middleware' => ['auth:sanctum','IsFacility']], function () {

 
   

});

Route::group(['middleware' => ['auth:owners']], function () {

   
   
});

