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
Route::group(['prefix' => 'back', 'namespace' => 'back'], function () {

    // DILLER KISMI
    Route::group(['prefix' => 'language', 'namespace' => 'language'], function () {
        Route::get('', [\App\Http\Controllers\api\back\language\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\language\indexController::class, 'store']);
        Route::post('rank-setter', [\App\Http\Controllers\api\back\language\indexController::class, 'rankSetter']);

        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\language\indexController::class, 'edit']);  // bu bize first of fail gibi gorev sağlıyor
            Route::get('show', [\App\Http\Controllers\api\back\language\indexController::class, 'show']);  // bu bize first of fail gibi gorev sağlıyor
            Route::post('update', [\App\Http\Controllers\api\back\language\indexController::class, 'update']); // bu verimizi güncelliyor
            Route::get('delete', [\App\Http\Controllers\api\back\language\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\language\indexController::class, 'isActiveSetter']);
            Route::post('is-default', [\App\Http\Controllers\api\back\language\indexController::class, 'isDefaultSetter']);
        });
    });

    // SERVISLER KISMI
    Route::group(['prefix' => 'service', 'namespace' => 'service'], function () {
        Route::get('', [\App\Http\Controllers\api\back\service\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\service\indexController::class, 'store']);
        Route::post('rank-setter', [\App\Http\Controllers\api\back\service\indexController::class, 'rankSetter']);

        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\service\indexController::class, 'edit']);  // bu bize first of fail gibi gorev sağlıyor
            Route::get('show', [\App\Http\Controllers\api\back\service\indexController::class, 'show']);  // bu bize first of fail gibi gorev sağlıyor
            Route::post('update', [\App\Http\Controllers\api\back\service\indexController::class, 'update']); // bu verimizi güncelliyor
            Route::get('delete', [\App\Http\Controllers\api\back\service\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\service\indexController::class, 'isActiveSetter']);
        });
    });

    // DUYURU KATEGOIRİLERİ KISMI
    Route::group(['prefix' => 'duyuru-kategoriler', 'namespace' => 'duyuru_kategoriler'], function () {
        Route::get('', [\App\Http\Controllers\api\back\duyuru_kategoriler\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\duyuru_kategoriler\indexController::class, 'store']);
        Route::post('rank-setter', [\App\Http\Controllers\api\back\duyuru_kategoriler\indexController::class, 'rankSetter']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\duyuru_kategoriler\indexController::class, 'edit']);  // bu bize first of fail gibi gorev sağlıyor
            Route::get('show', [\App\Http\Controllers\api\back\duyuru_kategoriler\indexController::class, 'edit']);  // bu bize first of fail gibi gorev sağlıyor
            Route::post('update', [\App\Http\Controllers\api\back\duyuru_kategoriler\indexController::class, 'update']);  // bu bize first of fail gibi gorev sağlıyor
            Route::get('delete', [\App\Http\Controllers\api\back\duyuru_kategoriler\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\duyuru_kategoriler\indexController::class, 'isActiveSetter']);
            Route::post('is-default', [\App\Http\Controllers\api\back\duyuru_kategoriler\indexController::class, 'isDefaultSetter']);
        });
    });


    // DUYURULAR KISMI
    Route::group(['prefix' => 'duyurular', 'namespace' => 'duyurular'], function () {
        Route::get('', [\App\Http\Controllers\api\back\duyurular\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\duyurular\indexController::class, 'store']);
        Route::post('rank-setter', [\App\Http\Controllers\api\back\duyurular\indexController::class, 'rankSetter']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\duyurular\indexController::class, 'edit']);  // bu bize first of fail gibi gorev sağlıyor
            Route::get('show', [\App\Http\Controllers\api\back\duyurular\indexController::class, 'edit']);  // bu bize first of fail gibi gorev sağlıyor
            Route::post('update', [\App\Http\Controllers\api\back\duyurular\indexController::class, 'update']);  // bu bize first of fail gibi gorev sağlıyor
            Route::get('delete', [\App\Http\Controllers\api\back\duyurular\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\duyurular\indexController::class, 'isActiveSetter']);
        });
    });


    // DUYURU YORUMLARI KISMI
    Route::group(['prefix' => 'duyuru-yorumlari', 'namespace' => 'duyuru_yorumlari'], function () {
        Route::get('', [\App\Http\Controllers\api\back\duyuru_yorumlari\indexController::class, 'index']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\duyuru_yorumlari\indexController::class, 'edit']);  // bu bize first of fail gibi gorev sağlıyor
            Route::post('cevapla', [\App\Http\Controllers\api\back\duyuru_yorumlari\indexController::class, 'cevapla']);  // bu bize first of fail gibi gorev sağlıyor
            Route::get('delete', [\App\Http\Controllers\api\back\duyuru_yorumlari\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\duyuru_yorumlari\indexController::class, 'isActiveSetter']);
        });
    });


    // SOSYAL MEDYA EKLEME KISMI AYARLANAMSI
    Route::group(['prefix' => 'sosyal-medya', 'namespace' => 'sosyal_medya'], function () {
        Route::get('', [\App\Http\Controllers\api\back\sosyal_medya\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\sosyal_medya\indexController::class, 'store']);
        Route::post('rank-setter', [\App\Http\Controllers\api\back\sosyal_medya\indexController::class, 'rankSetter']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\sosyal_medya\indexController::class, 'edit']);  // bu bize first of fail gibi gorev sağlıyor
            Route::get('delete', [\App\Http\Controllers\api\back\sosyal_medya\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\sosyal_medya\indexController::class, 'isActiveSetter']);
        });
    });

});
