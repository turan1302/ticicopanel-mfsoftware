<?php

namespace App\Http\Controllers\back\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except("logout");
    }

    // LOGIN EKRANI
    public function login(){
        return view('back.login.index');
    }

    // LOGIN OLMA KISMI
    public function do_login(){

    }

    // LOGOUT OLMA KISMI
    public function logout(){

    }
}

