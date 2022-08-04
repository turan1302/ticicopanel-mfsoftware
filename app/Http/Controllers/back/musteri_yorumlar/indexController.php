<?php

namespace App\Http\Controllers\back\musteri_yorumlar;

use App\Http\Controllers\Controller;
use App\Models\MusteriYorumModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.musteri_yorumlar.index');
    }

    // EKLEME KSIMI AYARLANMASI
    public function create(){
        return view('back.musteri_yorumlar.create');
    }

    // GUNCELLEME KISMI
    public function edit(MusteriYorumModel $item){
        return view('back.musteri_yorumlar.edit',compact('item'));
    }

    // GORUNTULEME KISMI
    public function show(MusteriYorumModel $item){
        return view('back.musteri_yorumlar.show',compact('item'));
    }
}
