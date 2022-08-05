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

Route::group(['namespace' => 'back', 'as' => 'back.'], function () {

    /** LOGIN KISMI AYARLAMASI **/
    Route::group(['prefix' => 'login'], function () {
//        Route::get('');
    });


    /** ADMIN ANASAYFA KISMI AYARLANMASI **/
    Route::group(['prefix' => '', 'namespace' => 'home', 'as' => 'home.'], function () {
        Route::get('', [\App\Http\Controllers\back\home\indexController::class, 'index'])->name('index');
    });

    /** DIL KISMI AYARLAMA **/
    Route::group(['prefix' => 'language', 'namespace' => 'language', 'as' => 'language.'], function () {
        Route::get('', [\App\Http\Controllers\back\language\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\language\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\language\indexController::class, 'edit'])->name('edit');
            Route::get('show', [\App\Http\Controllers\back\language\indexController::class, 'show'])->name('show');
        });
    });

    /** SERVISLER KISMI AYARLANMASI **/
    Route::group(['prefix' => 'service', 'namespace' => 'service', 'as' => 'service.'], function () {
        Route::get('', [\App\Http\Controllers\back\service\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\service\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\service\indexController::class, 'edit'])->name('edit');
            Route::get('show', [\App\Http\Controllers\back\service\indexController::class, 'show'])->name('show');
        });
    });

    /** DUYURU KATEGIORİLERİ KISMI AYARLANMASI **/
    Route::group(['prefix' => 'duyuru-kategoriler', 'namespace' => 'duyuru_kategoriler', 'as' => 'duyuru_kategoriler.'], function () {
        Route::get('', [\App\Http\Controllers\back\duyuru_kategoriler\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\duyuru_kategoriler\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\duyuru_kategoriler\indexController::class, 'edit'])->name('edit');
            Route::get('show', [\App\Http\Controllers\back\duyuru_kategoriler\indexController::class, 'show'])->name('show');
        });
    });

    /** DUYURULAR KISMI **/
    Route::group(['prefix' => 'duyurular', 'namespace' => 'duyurular', 'as' => 'duyurular.'], function () {
        Route::get('', [\App\Http\Controllers\back\duyurular\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\duyurular\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\duyurular\indexController::class, 'edit'])->name('edit');
            Route::get('show', [\App\Http\Controllers\back\duyurular\indexController::class, 'show'])->name('show');
        });
    });

    /** DUYURU YORUMLARI **/
    Route::group(['prefix' => 'duyuru-yorumlar', 'namespace' => 'duyuru_yorumlar', 'as' => 'duyuru_yorumlar.'], function () {
        Route::get('', [\App\Http\Controllers\back\duyuru_yorumlar\indexController::class, 'index'])->name('index');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\duyuru_yorumlar\indexController::class, 'edit'])->name('edit');
        });
    });


    /** SOSYAL MEDYA KISMI AYARLANAMSI **/
    Route::group(['prefix' => 'sosyal-medya', 'namespace' => 'sosyal_medya', 'as' => 'sosyal_medya.'], function () {
        Route::get('', [\App\Http\Controllers\back\sosyal_medya\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\sosyal_medya\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\sosyal_medya\indexController::class, 'edit'])->name('edit');
            Route::get('show', [\App\Http\Controllers\back\sosyal_medya\indexController::class, 'show'])->name('show');
        });
    });

    /** SLIDER KISMI AYARLANAMSI **/
    Route::group(['prefix' => 'sliderlar', 'namespace' => 'sliderlar', 'as' => 'sliderlar.'], function () {
        Route::get('', [\App\Http\Controllers\back\sliderlar\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\sliderlar\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\sliderlar\indexController::class, 'edit'])->name('edit');
            Route::get('show', [\App\Http\Controllers\back\sliderlar\indexController::class, 'show'])->name('show');
        });
    });

    /** PARTNER KISMI AYARLANAMSI **/
    Route::group(['prefix' => 'partnerlar', 'namespace' => 'partnerlar', 'as' => 'partnerlar.'], function () {
        Route::get('', [\App\Http\Controllers\back\partnerlar\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\partnerlar\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\partnerlar\indexController::class, 'edit'])->name('edit');
            Route::get('show', [\App\Http\Controllers\back\partnerlar\indexController::class, 'show'])->name('show');
        });
    });

    /** EKIP KISMI AYARLAMASI **/
    Route::group(['prefix' => 'ekip', 'namespace' => 'ekip', 'as' => 'ekip.'], function () {
        Route::get('', [\App\Http\Controllers\back\ekip\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\ekip\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\ekip\indexController::class, 'edit'])->name('edit');
            Route::get('show', [\App\Http\Controllers\back\ekip\indexController::class, 'show'])->name('show');
        });
    });

    /** MENULER KISMI AYARLANMASI **/
    Route::group(['prefix' => 'menuler', 'namespace' => 'menuler', 'as' => 'menuler.'], function () {
        Route::get('', [\App\Http\Controllers\back\menuler\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\menuler\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\menuler\indexController::class, 'edit'])->name('edit');
            Route::get('show', [\App\Http\Controllers\back\menuler\indexController::class, 'show'])->name('show');
        });
    });

    /** SAYFALAR KISMI AYARLANMASI **/
    Route::group(['prefix' => 'sayfalar', 'namespace' => 'sayfalar', 'as' => 'sayfalar.'], function () {
        Route::get('', [\App\Http\Controllers\back\sayfalar\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\sayfalar\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\sayfalar\indexController::class, 'edit'])->name('edit');
            Route::get('show', [\App\Http\Controllers\back\sayfalar\indexController::class, 'show'])->name('show');
        });
    });

    /** MUSTERI YORUMLARI KISMI AYARLANMASI **/
    Route::group(['prefix' => 'musteri-yorumlar', 'namespace' => 'musteri_yorumlar', 'as' => 'musteri_yorumlar.'], function () {
        Route::get('', [\App\Http\Controllers\back\musteri_yorumlar\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\musteri_yorumlar\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\musteri_yorumlar\indexController::class, 'edit'])->name('edit');
            Route::get('show', [\App\Http\Controllers\back\musteri_yorumlar\indexController::class, 'show'])->name('show');
        });
    });

    /** ILETISIM MESAJLARI KISMI AYARLANMASI **/
    Route::group(['prefix' => 'iletisim-mesajlari', 'namespace' => 'iletisim_mesajlari', 'as' => 'iletisim_mesajlari.'], function () {
        Route::get('', [\App\Http\Controllers\back\iletisim_mesajlari\indexController::class, 'index'])->name('index');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('show', [\App\Http\Controllers\back\iletisim_mesajlari\indexController::class, 'show'])->name('show');
        });
    });

    /** ABONE KISMI AYARLANMASI **/
    Route::group(['prefix' => 'aboneler', 'namespace' => 'aboneler', 'as' => 'aboneler.'], function () {
        Route::get('', [\App\Http\Controllers\back\aboneler\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\aboneler\indexController::class, 'create'])->name('create');
    });

    /** SERTIFIKALAR KISMI AYARLANMASI **/
    Route::group(['prefix' => 'sertifikalar', 'namespace' => 'sertifikalar', 'as' => 'sertifikalar.'], function () {
        Route::get('', [\App\Http\Controllers\back\sertifikalar\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\sertifikalar\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\sertifikalar\indexController::class, 'edit'])->name('edit');
            Route::get('show', [\App\Http\Controllers\back\sertifikalar\indexController::class, 'show'])->name('show');
        });
    });

    /** YETKILER KISMI AYARLANMASI **/
    Route::group(['prefix' => 'yetkiler', 'namespace' => 'yetkiler', 'as' => 'yetkiler.'], function () {
        Route::get('', [\App\Http\Controllers\back\yetkiler\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\yetkiler\indexController::class, 'create'])->name('create');
        Route::group(['prefix' => '{item}'], function () {
            Route::get('edit', [\App\Http\Controllers\back\yetkiler\indexController::class, 'edit'])->name('edit');
        });
    });
});
