<?php

namespace App\Http\Controllers\back\ekip;

use App\Http\Controllers\Controller;
use App\Models\EkipModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.ekip.index');
    }

    // EKLEME SAYFASI
    public function create(){
        return view('back.ekip.create');
    }

    // GUNCELLEME SAYFASI
    public function edit(EkipModel $item){
        return view('back.ekip.edit',compact('item'));
    }
}
