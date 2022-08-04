<?php

namespace App\Http\Controllers\back\menuler;

use App\Http\Controllers\Controller;
use App\Models\MenuModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.menuler.index');
    }

    // EKLEME SAYFASI
    public function create(){
        $menuler = MenuModel::where(array(
            "menu_durum" => 1
        ))->orderBy("menu_sira","asc")->get();
        return view('back.menuler.create',compact('menuler'));
    }
}
