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
Route::group(['prefix' => 'back', 'namespace' => 'back','middleware'=>'auth'], function () {

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
            Route::get('show', [\App\Http\Controllers\api\back\duyuru_kategoriler\indexController::class, 'show']);  // bu bize first of fail gibi gorev sağlıyor
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
            Route::get('show', [\App\Http\Controllers\api\back\duyurular\indexController::class, 'show']);  // bu bize first of fail gibi gorev sağlıyor
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
            Route::get('show', [\App\Http\Controllers\api\back\sosyal_medya\indexController::class, 'show']);  // bu bize first of fail gibi gorev sağlıyor
            Route::post('update', [\App\Http\Controllers\api\back\sosyal_medya\indexController::class, 'update']);
            Route::get('delete', [\App\Http\Controllers\api\back\sosyal_medya\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\sosyal_medya\indexController::class, 'isActiveSetter']);
        });
    });

    // SLIDER KISMI AYARLANMASI
    Route::group(['prefix' => 'sliderlar', 'namespace' => 'sliderlar'], function () {
        Route::get('', [\App\Http\Controllers\api\back\sliderlar\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\sliderlar\indexController::class, 'store']);
        Route::post('rank-setter', [\App\Http\Controllers\api\back\sliderlar\indexController::class, 'rankSetter']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\sliderlar\indexController::class, 'edit']);  // bu bize first of fail gibi gorev sağlıyor
            Route::get('show', [\App\Http\Controllers\api\back\sliderlar\indexController::class, 'show']);  // bu bize first of fail gibi gorev sağlıyor
            Route::post('update', [\App\Http\Controllers\api\back\sliderlar\indexController::class, 'update']);  // bu bize first of fail gibi gorev sağlıyor
            Route::get('delete', [\App\Http\Controllers\api\back\sliderlar\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\sliderlar\indexController::class, 'isActiveSetter']);
        });
    });

    // PARTNERLAR KISMI AYARLANMASI
    Route::group(['prefix' => 'partnerlar', 'namespace' => 'partnerlar'], function () {
        Route::get('', [\App\Http\Controllers\api\back\partnerlar\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\partnerlar\indexController::class, 'store']);
        Route::post('rank-setter', [\App\Http\Controllers\api\back\partnerlar\indexController::class, 'rankSetter']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\partnerlar\indexController::class, 'edit']);  // bu bize first of fail gibi gorev sağlıyor
            Route::get('show', [\App\Http\Controllers\api\back\partnerlar\indexController::class, 'show']);  // bu bize first of fail gibi gorev sağlıyor
            Route::post('update', [\App\Http\Controllers\api\back\partnerlar\indexController::class, 'update']);  // bu bize first of fail gibi gorev sağlıyor
            Route::get('delete', [\App\Http\Controllers\api\back\partnerlar\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\partnerlar\indexController::class, 'isActiveSetter']);
        });
    });

    // EKIP KISMI AYARLANAMSI
    Route::group(['prefix' => 'ekip', 'namespace' => 'ekip'], function () {
        Route::get('', [\App\Http\Controllers\api\back\ekip\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\ekip\indexController::class, 'store']);
        Route::post('rank-setter', [\App\Http\Controllers\api\back\ekip\indexController::class, 'rankSetter']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\ekip\indexController::class, 'edit']);
            Route::get('show', [\App\Http\Controllers\api\back\ekip\indexController::class, 'show']);
            Route::post('update', [\App\Http\Controllers\api\back\ekip\indexController::class, 'update']);
            Route::get('delete', [\App\Http\Controllers\api\back\ekip\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\ekip\indexController::class, 'isActiveSetter']);
        });
    });

    // MENULER KISMI AYARLANMASI
    Route::group(['prefix' => 'menuler', 'namespace' => 'menuler'], function () {
        Route::get('', [\App\Http\Controllers\api\back\menuler\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\menuler\indexController::class, 'store']);
        Route::post('rank-setter', [\App\Http\Controllers\api\back\menuler\indexController::class, 'rankSetter']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\menuler\indexController::class, 'edit']);
            Route::get('show', [\App\Http\Controllers\api\back\menuler\indexController::class, 'show']);
            Route::post('update', [\App\Http\Controllers\api\back\menuler\indexController::class, 'update']);
            Route::get('delete', [\App\Http\Controllers\api\back\menuler\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\menuler\indexController::class, 'isActiveSetter']);
        });
    });

    // SAYFALAR KISMI AYARLANMASI
    Route::group(['prefix' => 'sayfalar', 'namespace' => 'sayfalar'], function () {
        Route::get('', [\App\Http\Controllers\api\back\sayfalar\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\sayfalar\indexController::class, 'store']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\sayfalar\indexController::class, 'edit']);
            Route::get('show', [\App\Http\Controllers\api\back\sayfalar\indexController::class, 'show']);
            Route::post('update', [\App\Http\Controllers\api\back\sayfalar\indexController::class, 'update']);
            Route::get('delete', [\App\Http\Controllers\api\back\sayfalar\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\sayfalar\indexController::class, 'isActiveSetter']);
        });
    });

    // MUSTERI YORUMLARI KISMI AYARLANMASI
    Route::group(['prefix' => 'musteri-yorumlar', 'namespace' => 'musteri_yorumlar'], function () {
        Route::get('', [\App\Http\Controllers\api\back\musteri_yorumlar\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\musteri_yorumlar\indexController::class, 'store']);
        Route::post('rank-setter', [\App\Http\Controllers\api\back\musteri_yorumlar\indexController::class, 'rankSetter']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\musteri_yorumlar\indexController::class, 'edit']);
            Route::get('show', [\App\Http\Controllers\api\back\musteri_yorumlar\indexController::class, 'show']);
            Route::post('update', [\App\Http\Controllers\api\back\musteri_yorumlar\indexController::class, 'update']);
            Route::get('delete', [\App\Http\Controllers\api\back\musteri_yorumlar\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\musteri_yorumlar\indexController::class, 'isActiveSetter']);
        });
    });

    // ILETISIM MESAJLARI KISMI AYARLANMAASI
    Route::group(['prefix' => 'iletisim-mesajlari', 'namespace' => 'iletisim_mesajlari'], function () {
        Route::get('', [\App\Http\Controllers\api\back\iletisim_mesajlari\indexController::class, 'index']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('show', [\App\Http\Controllers\api\back\iletisim_mesajlari\indexController::class, 'show']);
            Route::post('reply', [\App\Http\Controllers\api\back\iletisim_mesajlari\indexController::class, 'reply']);
            Route::get('delete', [\App\Http\Controllers\api\back\iletisim_mesajlari\indexController::class, 'delete']);
        });
    });

    // ABONELER KISMI AYARLANMASI
    Route::group(['prefix' => 'aboneler', 'namespace' => 'aboneler'], function () {
        Route::get('', [\App\Http\Controllers\api\back\aboneler\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\aboneler\indexController::class, 'store']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('delete', [\App\Http\Controllers\api\back\aboneler\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\aboneler\indexController::class, 'isActiveSetter']);
        });
    });

    // SERTIFIKALAR KISMI AYARLANMASI
    Route::group(['prefix' => 'sertifikalar', 'namespace' => 'sertifikalar'], function () {
        Route::get('', [\App\Http\Controllers\api\back\sertifikalar\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\sertifikalar\indexController::class, 'store']);
        Route::post('rank-setter', [\App\Http\Controllers\api\back\sertifikalar\indexController::class, 'rankSetter']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\sertifikalar\indexController::class, 'edit']);
            Route::get('show', [\App\Http\Controllers\api\back\sertifikalar\indexController::class, 'show']);
            Route::post('update', [\App\Http\Controllers\api\back\sertifikalar\indexController::class, 'update']);
            Route::get('delete', [\App\Http\Controllers\api\back\sertifikalar\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\sertifikalar\indexController::class, 'isActiveSetter']);
        });
    });

    // YETKILER KISMI AYARLANMASI
    Route::group(['prefix' => 'yetkiler', 'namespace' => 'yetkiler'], function () {
        Route::get('', [\App\Http\Controllers\api\back\yetkiler\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\yetkiler\indexController::class, 'store']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\yetkiler\indexController::class, 'edit']);
            Route::post('update', [\App\Http\Controllers\api\back\yetkiler\indexController::class, 'update']);
            Route::get('delete', [\App\Http\Controllers\api\back\yetkiler\indexController::class, 'delete']);
            Route::post('is-active', [\App\Http\Controllers\api\back\yetkiler\indexController::class, 'isActiveSetter']);

            // YETKI AYAR KISMININ GERCEKLESTIRILMESINI AYARLAYALIM
            Route::get('verilen-yetkiler', [\App\Http\Controllers\api\back\yetkiler\indexController::class, 'verilen_yetkiler'])->name('verilen_yetkiler');
            Route::post('verilen-yetki-guncelle', [\App\Http\Controllers\api\back\yetkiler\indexController::class, 'verilen_yetki_guncelleme'])->name('verilen_yetki_guncelleme');

        });
    });

    // KULLANICILAR KISMI AYARLANMASI
    Route::group(['prefix' => 'kullanicilar', 'namespace' => 'kullanicilar'], function () {
        Route::get('', [\App\Http\Controllers\api\back\kullanicilar\indexController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\api\back\kullanicilar\indexController::class, 'store']);
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\api\back\kullanicilar\indexController::class, 'edit']);
            Route::get('show', [\App\Http\Controllers\api\back\kullanicilar\indexController::class, 'show']);
            Route::post('update', [\App\Http\Controllers\api\back\kullanicilar\indexController::class, 'update']);
            Route::post('is-active', [\App\Http\Controllers\api\back\kullanicilar\indexController::class, 'isActiveSetter']);
            Route::get('delete', [\App\Http\Controllers\api\back\kullanicilar\indexController::class, 'delete']);
        });
    });

    // AYARLAR KISMI AYARLANMASI
    Route::group(['prefix' => 'ayarlar', 'namespace' => 'ayarlar'], function () {
        Route::get('', [\App\Http\Controllers\api\back\ayarlar\indexController::class, 'index']);
        Route::post('update', [\App\Http\Controllers\api\back\ayarlar\indexController::class, 'update']);
        Route::post('logo-update', [\App\Http\Controllers\api\back\ayarlar\indexController::class, 'logo_update']);
        Route::post('favicon-update', [\App\Http\Controllers\api\back\ayarlar\indexController::class, 'favicon_update']);

        // TOPLU MESAJ GONDEWR
        Route::post('toplu-mesaj-gonder', [\App\Http\Controllers\api\back\ayarlar\indexController::class, 'toplu_mesaj_gonder']);
    });

});
