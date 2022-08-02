<?php

namespace App\Http\Controllers\back\ekip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.ekip.index');
    }

    // EKLEME SAYFASI
    public function create(){
        echo "Yes";
        die;
    }
}
