<?php

namespace App\Http\Controllers\back\iletisim_mesajlari;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\IletisimMesajModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('iletisim_mesajlari',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('iletisim_mesajlari',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.iletisim_mesajlari.index');
    }

    // GOREUNTULEME VE MESAJ GONDERME KISMI AYARLAMASI ()
    public function show(IletisimMesajModel $item){

        if (myHelper::yetkiKontrol('iletisim_mesajlari',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $item->update(array(
            "im_okundu_bilgisi" => 1
        ));
        return view('back.iletisim_mesajlari.show',compact('item'));
    }
}
