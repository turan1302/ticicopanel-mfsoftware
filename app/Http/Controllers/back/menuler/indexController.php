<?php

namespace App\Http\Controllers\back\menuler;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\MenuModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('menuler',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('menuler',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.menuler.index');
    }

    // EKLEME SAYFASI
    public function create(){

        if (myHelper::yetkiKontrol('menuler',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $menuler = MenuModel::where(array(
            "menu_durum" => 1
        ))->orderBy("menu_sira","asc")->get();
        return view('back.menuler.create',compact('menuler'));
    }

    // GUNCELLEME SAYAFSI
    public function edit(MenuModel $item){

        if (myHelper::yetkiKontrol('menuler',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $menuler = MenuModel::where(array(
            "menu_durum" => 1
        ))->orderBy("menu_sira","asc")->get();
        return view('back.menuler.edit',compact('menuler','item'));
    }

    // GORUNTULEME SAYFASI
    public function show(MenuModel $item){

        if (myHelper::yetkiKontrol('menuler',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $menuler = MenuModel::where(array(
            "menu_durum" => 1
        ))->orderBy("menu_sira","asc")->get();
        return view('back.menuler.show',compact('menuler','item'));
    }
}
