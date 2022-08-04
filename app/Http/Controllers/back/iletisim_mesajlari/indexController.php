<?php

namespace App\Http\Controllers\back\iletisim_mesajlari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.iletisim_mesajlari.index');
    }

    // EKLEME KISMI AYARLAMASI
    public function create(){
        echo "Yes";
        die;
    }
}
