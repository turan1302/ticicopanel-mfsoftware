<?php

namespace App\Http\Controllers\back\duyuru_kategoriler;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\DuyuruKategoriModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('duyuru_kategorileri', "aktiflik") === false) {
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

        if (myHelper::yetkiKontrol('duyuru_kategorileri', "listeleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.duyuru_kategoriler.index');
    }

    // EKLEME KISMI
    public function create(){

        if (myHelper::yetkiKontrol('duyuru_kategorileri', "ekleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.duyuru_kategoriler.create');
    }

    // GUNCELLEME SAYFASI
    public function edit(DuyuruKategoriModel $item){

        if (myHelper::yetkiKontrol('duyuru_kategorileri', "guncelleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.duyuru_kategoriler.edit',compact('item'));
    }

    // GORUNTULEME SAYGFASI
    public function show(DuyuruKategoriModel $item){

        if (myHelper::yetkiKontrol('duyuru_kategorileri', "goruntuleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.duyuru_kategoriler.show',compact('item'));
    }
}
