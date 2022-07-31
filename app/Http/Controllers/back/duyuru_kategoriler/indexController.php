<?php

namespace App\Http\Controllers\back\duyuru_kategoriler;

use App\Http\Controllers\Controller;
use App\Models\DuyuruKategoriModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.duyuru_kategoriler.index');
    }

    // EKLEME KISMI
    public function create(){
        return view('back.duyuru_kategoriler.create');
    }

    // GUNCELLEME SAYFASI
    public function edit(DuyuruKategoriModel $item){
        return view('back.duyuru_kategoriler.edit',compact('item'));
    }
}
