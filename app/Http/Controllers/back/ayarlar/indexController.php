<?php

namespace App\Http\Controllers\back\ayarlar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.ayarlar.index');
    }

    // WEBMASTER AYARLARI
    public function webmaster(){
        return view('back.ayarlar.webmaster');
    }

    // LOGO AYARLARI
    public function logo(){
        return view('back.ayarlar.logo');
    }

    // FAVICON AYALARI
    public function favicon(){
        return view('back.ayarlar.favicon');
    }

    // ILETISIM KISMI AYARLARI
    public function iletisim(){
        return view('back.ayarlar.iletisim');
    }

    // TOPLU MESAJ KISMI
    public function toplu_mesaj(){
        return view('back.ayarlar.toplu_mesaj');
    }
}
