<?php

namespace App\Http\Controllers\back\kullanicilar;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.kullanicilar.index');
    }

    // EKLEME KISMI
    public function create(){
        return view('back.kullanicilar.create');
    }

    // GUNCELLEME KISMI
    public function edit(User $item){
        return view('back.kullanicilar.edit');
    }
}
