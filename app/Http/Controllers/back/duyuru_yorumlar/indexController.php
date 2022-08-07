<?php

namespace App\Http\Controllers\back\duyuru_yorumlar;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\DuyuruYorumlariModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('duyuru_yorumlar',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('duyuru_yorumlar',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.duyuru_yorumlari.index');
    }

    // DUYURU YORUM GORUNTULE KISMI AYARLANMASI GERCEKLESTIRIECEK
    public function edit(DuyuruYorumlariModel $item){

        if (myHelper::yetkiKontrol('duyuru_yorumlar',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.duyuru_yorumlari.edit',compact('item'));
    }
}
