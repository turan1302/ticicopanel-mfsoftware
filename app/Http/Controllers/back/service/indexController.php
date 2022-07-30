<?php

namespace App\Http\Controllers\back\service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.service.index');
    }
}
