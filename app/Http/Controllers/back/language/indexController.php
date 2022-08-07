<?php

namespace App\Http\Controllers\back\language;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\LanguageModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('diller',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('diller',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.language.index');
    }

    // YENI EKLEME SAYFASI
    public function create(){
        if (myHelper::yetkiKontrol('diller',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.language.create');
    }

    // GUNCELLEME SAYFASI
    public function edit(LanguageModel $item){

        if (myHelper::yetkiKontrol('diller',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.language.edit',compact('item'));
    }

    // GORUNTULEME SAYFASI
    public function show(LanguageModel $item){

        if (myHelper::yetkiKontrol('diller',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.language.show',compact('item'));
    }
}
