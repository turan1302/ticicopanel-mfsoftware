<?php

namespace App\Http\Controllers\back\ekip;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\EkipModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('ekibimiz',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('ekibimiz',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.ekip.index');
    }

    // EKLEME SAYFASI
    public function create(){

        if (myHelper::yetkiKontrol('ekibimiz',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.ekip.create');
    }

    // GUNCELLEME SAYFASI
    public function edit(EkipModel $item){

        if (myHelper::yetkiKontrol('ekibimiz',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.ekip.edit',compact('item'));
    }

    //  GORUNTULEME SAYFASI
    public function show(EkipModel $item){

        if (myHelper::yetkiKontrol('ekibimiz',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.ekip.show',compact('item'));
    }
}
