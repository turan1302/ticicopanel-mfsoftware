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
    });
});
