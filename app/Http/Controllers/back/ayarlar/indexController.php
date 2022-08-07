<?php

namespace App\Http\Controllers\back\ayarlar;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('ayarlar', "aktiflik") === false) {
                return redirect()->route('back.home.index')->with(array(
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "Yetkiniz Yok"
                ));
            }
            return $next($request);
        });
    }

    public function index(){

        if (myHelper::yetkiKontrol('ayarlar', "listeleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.ayarlar.index');
    }

    // WEBMASTER AYARLARI
    public function webmaster(){

        if (myHelper::yetkiKontrol('ayarlar', "listeleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.ayarlar.webmaster');
    }

    // LOGO AYARLARI
    public function logo(){

        if (myHelper::yetkiKontrol('ayarlar', "listeleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.ayarlar.logo');
    }

    // FAVICON AYALARI
    public function favicon(){

        if (myHelper::yetkiKontrol('ayarlar', "listeleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.ayarlar.favicon');
    }

    // ILETISIM KISMI AYARLARI
    public function iletisim(){

        if (myHelper::yetkiKontrol('ayarlar', "listeleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.ayarlar.iletisim');
    }

    // TOPLU MESAJ KISMI
    public function toplu_mesaj(){

        if (myHelper::yetkiKontrol('ayarlar', "guncelleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.ayarlar.toplu_mesaj');
    }
}
