<?php

namespace App\Http\Controllers\back\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.home.index');
    }
}
