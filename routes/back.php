<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** LOGIN KISMI OLUSTURULACAK **/

Route::group(['namespace'=>'back','as'=>'back.'],function (){

    /** LOGIN KISMI AYARLAMASI **/
    Route::group(['prefix'=>'login'],function (){
//        Route::get('');
    });


    /** ADMIN ANASAYFA KISMI AYARLANMASI **/
    Route::group(['prefix'=>'','namespace'=>'home','as'=>'home.'],function (){
        Route::get('',[\App\Http\Controllers\back\home\indexController::class,'index'])->name('index');
    });

    /** DIL KISMI AYARLAMA **/
    Route::group(['prefix'=>'language','namespace'=>'language','as'=>'language.'],function (){
        Route::get('',[\App\Http\Controllers\back\language\indexController::class,'index'])->name('index');
        Route::get('create',[\App\Http\Controllers\back\language\indexController::class,'create'])->name('create');
        Route::group(['prefix'=>'{item}'],function (){
            Route::get('edit',[\App\Http\Controllers\back\language\indexController::class,'edit'])->name('edit');
            Route::get('show',[\App\Http\Controllers\back\language\indexController::class,'show'])->name('show');
        });
    });

    /** SERVISLER KISMI AYARLANMASI **/
    Route::group(['prefix' => 'service','namespace'=>'service','as'=>'service.'],function (){
        Route::get('',[\App\Http\Controllers\back\service\indexController::class,'index'])->name('index');
    });
});
