<?php

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



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::get('/profile','AuthController@profile');

Route::controller(BabyController::class)->group(function(){
    Route::post('/add-baby', 'insert');
    Route::get('/all-babies/{user_id}', 'index');
    Route::get('/baby-data/{id}', 'show');
    Route::post('/delete-baby/{id}', 'delete');
    Route::post('/update-baby/{id}', 'update');
});


Route::controller(TtrackersController::class)->group(function (){
    Route::post('/add-feeding/{user_id}','add_feeding');
    Route::post('/add-sleep/{user_id}','add_sleep');
    Route::post('/add-diaper/{user_id}','add_diaper');
});





