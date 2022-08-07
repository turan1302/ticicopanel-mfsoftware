<?php

namespace App\Http\Controllers\back\duyurular;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\DuyuruKategoriModel;
use App\Models\DuyuruModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('duyurular', "aktiflik") === false) {
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

        if (myHelper::yetkiKontrol('duyurular', "listeleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.duyurular.index');
    }

    // DUYURU EKLEME ISLEMI
    public function create(){

        if (myHelper::yetkiKontrol('duyurular', "ekleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $duyuru_kategoriler = DuyuruKategoriModel::where(array(
            "dkat_durum" => 1
        ))->orderBy("dkat_sira","asc")->get();
        return view('back.duyurular.create',compact('duyuru_kategoriler'));
    }

    // GUNCELLEME SAYFASI
    public function edit(DuyuruModel $item){

        if (myHelper::yetkiKontrol('duyurular', "guncelleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $duyuru_kategoriler = DuyuruKategoriModel::where(array(
            "dkat_durum" => 1
        ))->orderBy("dkat_sira","asc")->get();
        return view('back.duyurular.edit',compact('item','duyuru_kategoriler'));
    }

    // GORUNTULEME KISMI
    public function show(DuyuruModel $item){

        if (myHelper::yetkiKontrol('duyurular', "goruntuleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $duyuru_kategoriler = DuyuruKategoriModel::where(array(
            "dkat_durum" => 1
        ))->orderBy("dkat_sira","asc")->get();
        return view('back.duyurular.show',compact('item','duyuru_kategoriler'));
    }
}
