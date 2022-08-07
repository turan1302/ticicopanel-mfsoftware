<?php

namespace App\Http\Controllers\back\service;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\ServiceModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('servisler',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('servisler',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.service.index');
    }

    // YENI EKLEME KISMI
    public function create(){

        if (myHelper::yetkiKontrol('servisler',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.service.create');
    }

    // GUNCELLEME SAYFASI
    public function edit(ServiceModel $item){

        if (myHelper::yetkiKontrol('servisler',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.service.edit',compact('item'));
    }

    // GORUNTULEME SAYFASI
    public function show(ServiceModel $item){

        if (myHelper::yetkiKontrol('servisler',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.service.show',compact('item'));
    }
}
