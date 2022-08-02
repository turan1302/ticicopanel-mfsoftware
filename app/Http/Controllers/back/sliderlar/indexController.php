<?php

namespace App\Http\Controllers\back\sliderlar;

use App\Http\Controllers\Controller;
use App\Models\SliderModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.sliderlar.index');
    }

    // SLIDER EKLEME SAYFASI
    public function create(){
        return view('back.sliderlar.create');
    }

    // SLIDER GUNCELLEME SAYFASI
    public function edit(SliderModel $item){
        return view('back.sliderlar.edit',compact('item'));
    }
}
