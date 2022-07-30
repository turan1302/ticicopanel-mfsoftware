<?php

namespace App\Http\Controllers\back\service;

use App\Http\Controllers\Controller;
use App\Models\ServiceModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.service.index');
    }

    // YENI EKLEME KISMI
    public function create(){
        return view('back.service.create');
    }

    // GUNCELLEME SAYFASI
    public function edit(ServiceModel $item){
        return view('back.service.edit',compact('item'));
    }

    // GORUNTULEME SAYFASI
    public function show(ServiceModel $item){
        return view('back.service.show',compact('item'));
    }
}
