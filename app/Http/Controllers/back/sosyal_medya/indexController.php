<?php

namespace App\Http\Controllers\back\sosyal_medya;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\SosyalMedyaModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('sosyal_medya',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('sosyal_medya',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }


        return view('back.sosyal_medya.index');
    }

    // SOSYAL MEDYA EKLEME KISMI
    public function create(){

        if (myHelper::yetkiKontrol('sosyal_medya',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sosyal_medya.create');
    }

    // SOSYAL MEDYA GUNCELLEME KISMI
    public function edit(SosyalMedyaModel $item){

        if (myHelper::yetkiKontrol('sosyal_medya',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sosyal_medya.edit',compact('item'));
    }

    // SOSYAL MEDAYA GORUNTULEME KISMI
    public function show(SosyalMedyaModel $item){

        if (myHelper::yetkiKontrol('sosyal_medya',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sosyal_medya.show',compact('item'));
    }
}
