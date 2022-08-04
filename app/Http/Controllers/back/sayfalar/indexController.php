<?php

namespace App\Http\Controllers\back\sayfalar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.sayfalar.index');
    }

    // EKLEME KISMI
    public function create(){
        echo "Yes";
        die;
    }
}
