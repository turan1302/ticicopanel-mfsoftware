<?php

namespace App\Http\Controllers\back\partnerlar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.partnerlar.index');
    }

    // EKLEME SAYAFSI
    public function create(){
        echo "yes";
        die;
    }
}
