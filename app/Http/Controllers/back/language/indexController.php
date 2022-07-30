<?php

namespace App\Http\Controllers\back\language;

use App\Http\Controllers\Controller;
use App\Models\LanguageModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.language.index');
    }

    // YENI EKLEME SAYFASI
    public function create(){
        return view('back.language.create');
    }

    // GUNCELLEME SAYFASI
    public function edit(LanguageModel $item){
        return view('back.language.edit',compact('item'));
    }

    // GORUNTULEME SAYFASI
    public function show(LanguageModel $item){
        return view('back.language.show',compact('item'));
    }
}
