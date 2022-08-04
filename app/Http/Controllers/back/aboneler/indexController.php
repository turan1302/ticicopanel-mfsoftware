<?php

namespace App\Http\Controllers\back\aboneler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.aboneler.index');
    }

    // EKLEME KISMI
    public function create(){
        return view('back.aboneler.create');
    }
}
