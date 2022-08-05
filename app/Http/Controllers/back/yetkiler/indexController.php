<?php

namespace App\Http\Controllers\back\yetkiler;

use App\Http\Controllers\Controller;
use App\Models\YetkiModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.yetkiler.index');
    }

    // EKLEME KSMI
    public function create(){
        return view('back.yetkiler.create');
    }

    // GUNCLELEME KISMI
    public function edit(YetkiModel $item){
        return view('back.yetkiler.edit',compact('item'));
    }
}
