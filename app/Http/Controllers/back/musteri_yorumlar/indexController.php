<?php

namespace App\Http\Controllers\back\musteri_yorumlar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.musteri_yorumlar.index');
    }

    // EKLEME KSIMI AYARLANMASI
    public function create(){
        echo "Yes";
        die;
    }
}
