<?php

namespace App\Http\Controllers\back\menuler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.menuler.index');
    }

    // EKLEME SAYFASI
    public function create(){
        echo "Yes";
        die;
    }
}
