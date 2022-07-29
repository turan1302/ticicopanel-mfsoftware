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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


/** ADMIN KISMI **/
Route::group(['prefix'=>'back','namespace'=>'back'],function (){

    // DILLER KISMI
    Route::group(['prefix'=>'language','namespace'=>'language'],function (){
        Route::get('',[\App\Http\Controllers\api\back\language\indexController::class,'index']);
        Route::post('store',[\App\Http\Controllers\api\back\language\indexController::class,'store']);
        Route::post('rank-setter',[\App\Http\Controllers\api\back\language\indexController::class,'rankSetter']);

        Route::group(['prefix'=>'{item}'],function (){
            Route::get('edit',[\App\Http\Controllers\api\back\language\indexController::class,'edit']);
            Route::get('delete',[\App\Http\Controllers\api\back\language\indexController::class,'delete']);
            Route::post('is-active',[\App\Http\Controllers\api\back\language\indexController::class,'isActiveSetter']);
            Route::post('is-default',[\App\Http\Controllers\api\back\language\indexController::class,'isDefaultSetter']);
        });
    });
});
