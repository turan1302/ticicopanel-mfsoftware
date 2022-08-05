<?php

namespace App\Http\Controllers\back\yetkiler;

use App\Http\Controllers\Controller;
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
}
