<?php

namespace App\Http\Controllers\back\duyuru_yorumlar;

use App\Http\Controllers\Controller;
use App\Models\DuyuruYorumlariModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.duyuru_yorumlari.index');
    }

    // DUYURU YORUM GORUNTULE KISMI AYARLANMASI GERCEKLESTIRIECEK
    public function edit(DuyuruYorumlariModel $item){
        return view('back.duyuru_yorumlari.edit',compact('item'));
    }
}
