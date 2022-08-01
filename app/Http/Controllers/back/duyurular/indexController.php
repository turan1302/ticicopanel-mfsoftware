<?php

namespace App\Http\Controllers\back\duyurular;

use App\Http\Controllers\Controller;
use App\Models\DuyuruKategoriModel;
use App\Models\DuyuruModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.duyurular.index');
    }

    // DUYURU EKLEME ISLEMI
    public function create(){
        $duyuru_kategoriler = DuyuruKategoriModel::where(array(
            "dkat_durum" => 1
        ))->orderBy("dkat_sira","asc")->get();
        return view('back.duyurular.create',compact('duyuru_kategoriler'));
    }

    // GUNCELLEME SAYFASI
    public function edit(DuyuruModel $item){
        $duyuru_kategoriler = DuyuruKategoriModel::where(array(
            "dkat_durum" => 1
        ))->orderBy("dkat_sira","asc")->get();
        return view('back.duyurular.edit',compact('item','duyuru_kategoriler'));
    }

    // GORUNTULEME KISMI
    public function show(DuyuruModel $item){
        $duyuru_kategoriler = DuyuruKategoriModel::where(array(
            "dkat_durum" => 1
        ))->orderBy("dkat_sira","asc")->get();
        return view('back.duyurular.show',compact('item','duyuru_kategoriler'));
    }
}
