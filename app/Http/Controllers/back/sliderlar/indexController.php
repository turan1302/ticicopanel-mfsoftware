<?php

namespace App\Http\Controllers\back\sliderlar;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\SliderModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('sliderlar',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('sliderlar',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sliderlar.index');
    }

    // SLIDER EKLEME SAYFASI
    public function create(){

        if (myHelper::yetkiKontrol('sliderlar',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sliderlar.create');
    }

    // SLIDER GUNCELLEME SAYFASI
    public function edit(SliderModel $item){

        if (myHelper::yetkiKontrol('sliderlar',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sliderlar.edit',compact('item'));
    }

    // SLIDER GORUNTULEME SAYFASI
    public function show(SliderModel $item){

        if (myHelper::yetkiKontrol('sliderlar',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sliderlar.show',compact('item'));
    }
}
