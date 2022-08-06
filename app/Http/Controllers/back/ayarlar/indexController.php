<?php

namespace App\Http\Controllers\back\ayarlar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.ayarlar.index');
    }
}
