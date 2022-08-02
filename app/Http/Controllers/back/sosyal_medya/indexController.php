<?php

namespace App\Http\Controllers\back\sosyal_medya;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.sosyal_medya.index');
    }

    // SOSYAL MEDYA EKLEME KISMI
    public function create(){
        return view('back.sosyal_medya.create');
    }
}
