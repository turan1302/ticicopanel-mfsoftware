<?php

namespace App\Http\Controllers\back\home;

use App\Http\Controllers\Controller;
use App\Mail\MesajCevapMail;
use App\Models\IletisimMesajModel;
use App\Models\SertifikaModel;
use App\Models\ServiceModel;
use App\Models\YetkiModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        $sertifikalar = SertifikaModel::count();
        $servisler = ServiceModel::count();
        $mesajlar = IletisimMesajModel::count();
        $son_10_mesaj = IletisimMesajModel::orderByDesc("im_id")->get()->toJson();
        return view('back.home.index',compact('sertifikalar','servisler','mesajlar','son_10_mesaj'));
    }
}
