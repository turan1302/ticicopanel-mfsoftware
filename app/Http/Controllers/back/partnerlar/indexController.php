<?php

namespace App\Http\Controllers\back\partnerlar;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\PartnerModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('partnerler',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('partnerler',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.partnerlar.index');
    }

    // EKLEME SAYAFSI
    public function create(){

        if (myHelper::yetkiKontrol('partnerler',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.partnerlar.create');
    }

    // GUNCELLEME SAYFASI
    public function edit(PartnerModel $item){

        if (myHelper::yetkiKontrol('partnerler',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.partnerlar.edit',compact('item'));
    }

    // GORUNTULEME SAYFASI KISMI
    public function show(PartnerModel $item){

        if (myHelper::yetkiKontrol('partnerler',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.partnerlar.show',compact('item'));
    }

}
