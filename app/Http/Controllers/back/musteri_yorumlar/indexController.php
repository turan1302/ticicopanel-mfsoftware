<?php

namespace App\Http\Controllers\back\musteri_yorumlar;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\MusteriYorumModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('musteri_yorumlari',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('musteri_yorumlari',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.musteri_yorumlar.index');
    }

    // EKLEME KSIMI AYARLANMASI
    public function create(){

        if (myHelper::yetkiKontrol('musteri_yorumlari',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.musteri_yorumlar.create');
    }

    // GUNCELLEME KISMI
    public function edit(MusteriYorumModel $item){

        if (myHelper::yetkiKontrol('musteri_yorumlari',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.musteri_yorumlar.edit',compact('item'));
    }

    // GORUNTULEME KISMI
    public function show(MusteriYorumModel $item){

        if (myHelper::yetkiKontrol('musteri_yorumlari',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.musteri_yorumlar.show',compact('item'));
    }
}
