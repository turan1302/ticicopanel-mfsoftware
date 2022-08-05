<?php

namespace App\Http\Controllers\back\kullanicilar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.kullanicilar.index');
    }

    // EKLEME KISMI
    public function create(){
        return view('back.kullanicilar.create');
    }
}
