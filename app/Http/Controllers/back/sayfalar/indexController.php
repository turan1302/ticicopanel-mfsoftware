<?php

namespace App\Http\Controllers\back\sayfalar;

use App\Http\Controllers\Controller;
use App\Models\SayfaModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.sayfalar.index');
    }

    // EKLEME KISMI
    public function create(){
        return view('back.sayfalar.create');
    }

    // GUNCELLEME KISMI
    public function edit(SayfaModel $item){
        return view('back.sayfalar.edit',compact('item'));
    }

    // GORUNTULEME KISMI
    public function show(SayfaModel $item){
        return view('back.sayfalar.show',compact('item'));
    }
}
