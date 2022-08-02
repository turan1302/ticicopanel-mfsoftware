<?php

namespace App\Http\Controllers\back\sliderlar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.sliderlar.index');
    }

    // SLIDER EKLEME SAYFASI
    public function create(){
        echo "Yes";
        die;
    }
}
