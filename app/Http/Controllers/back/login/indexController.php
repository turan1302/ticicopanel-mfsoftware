<?php

namespace App\Http\Controllers\back\login;

use App\Http\Controllers\Controller;
use App\Http\Requests\back\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function do_login(LoginRequest $request){
        $data = $request->except("_token");

        $credentials = [
            "email" => $data['email'],
            "durum" => 1,
            "password" => $data['password']
        ];

        if (Auth::guard('yonetim')->attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('back.home.index')->with(array(
                "type" => "success",
                "title" => "Başarılı",
                "text" => "Hoşgeldiniz: ".\auth()->guard('yonetim')->user()->name
            ));
        }else{
            return redirect()->back()->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Hatalı Giriş"
            ));
        }
    }

    // LOGOUT OLMA KISMI
    public function logout(){
        \auth()->guard('yonetim')->logout();
        \request()->session()->flush();
        \request()->session()->regenerate();
        return redirect()->route('back.login')->with(array(
            "type" => "success",
            "title" => "Başarılı",
            "text" => "Çıkış İşlemi Başarılı"
        ));
    }
}

