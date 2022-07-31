<?php

namespace App\Http\Controllers\back\duyurular;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.duyurular.index');
    }

    // DUYURU EKLEME ISLEMI
    public function create(){
        echo "Ekle";
        die;
    }
}
