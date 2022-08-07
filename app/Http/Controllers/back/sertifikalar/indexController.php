<?php

namespace App\Http\Controllers\back\sertifikalar;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\SertifikaModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('sertifikalar',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('sertifikalar',"listeleme")===false){
            return redirect()->route('back.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sertifikalar.index');
    }

    // EKLEME KISMI
    public function create(){

        if (myHelper::yetkiKontrol('sertifikalar',"ekleme")===false){
            return redirect()->route('back.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sertifikalar.create');
    }

    // GUNCLELEME KISMI
    public function edit(SertifikaModel $item){

        if (myHelper::yetkiKontrol('sertifikalar',"guncelleme")===false){
            return redirect()->route('back.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sertifikalar.edit',compact('item'));
    }

    // GORUNTULEME KISMI
    public function show(SertifikaModel $item){

        if (myHelper::yetkiKontrol('sertifikalar',"goruntuleme")===false){
            return redirect()->route('back.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return view('back.sertifikalar.show',compact('item'));
    }
}
