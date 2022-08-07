<?php

namespace App\Http\Controllers\back\sayfalar;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\SayfaModel;
use Illuminate\Http\Request;

class indexController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('sayfalar',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('sayfalar',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sayfalar.index');
    }

    // EKLEME KISMI
    public function create(){

        if (myHelper::yetkiKontrol('sayfalar',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sayfalar.create');
    }

    // GUNCELLEME KISMI
    public function edit(SayfaModel $item){

        if (myHelper::yetkiKontrol('sayfalar',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sayfalar.edit',compact('item'));
    }

    // GORUNTULEME KISMI
    public function show(SayfaModel $item){

        if (myHelper::yetkiKontrol('sayfalar',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sayfalar.show',compact('item'));
    }
}
