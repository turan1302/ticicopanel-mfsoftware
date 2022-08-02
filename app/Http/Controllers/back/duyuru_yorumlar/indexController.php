<?php

namespace App\Http\Controllers\back\duyuru_yorumlar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.duyuru_yorumlari.index');
    }
}
