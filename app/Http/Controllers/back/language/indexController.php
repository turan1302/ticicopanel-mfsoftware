<?php

namespace App\Http\Controllers\back\language;

use App\Http\Controllers\Controller;
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
}
