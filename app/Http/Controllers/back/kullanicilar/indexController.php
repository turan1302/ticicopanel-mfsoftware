<?php

namespace App\Http\Controllers\back\kullanicilar;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\YetkiModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('kullanicilar',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('kullanicilar',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.kullanicilar.index');
    }

    // EKLEME KISMI
    public function create(){

        if (myHelper::yetkiKontrol('kullanicilar',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $yetkiler = YetkiModel::where(array(
            "yt_durum" => 1
        ))->orderBy('yt_baslik',"asc")->get();

        return view('back.kullanicilar.create',compact('yetkiler'));
    }

    // GUNCELLEME KISMI
    public function edit(User $item){

        if (myHelper::yetkiKontrol('kullanicilar',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $yetkiler = YetkiModel::where(array(
            "yt_durum" => 1
        ))->orderBy('yt_baslik',"asc")->get();

        return view('back.kullanicilar.edit',compact('item','yetkiler'));
    }

    // GORUNTULEME ISLEMI
    public function show(User $item){

        if (myHelper::yetkiKontrol('kullanicilar',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $yetkiler = YetkiModel::where(array(
            "yt_durum" => 1
        ))->orderBy('yt_baslik',"asc")->get();

        return view('back.kullanicilar.show',compact('item','yetkiler'));
    }
}
