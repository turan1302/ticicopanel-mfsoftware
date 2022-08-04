<?php

namespace App\Http\Controllers\back\iletisim_mesajlari;

use App\Http\Controllers\Controller;
use App\Models\IletisimMesajModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.iletisim_mesajlari.index');
    }

    // GOREUNTULEME VE MESAJ GONDERME KISMI AYARLAMASI ()
    public function show(IletisimMesajModel $item){
        $item->update(array(
            "im_okundu_bilgisi" => 1
        ));
        return view('back.iletisim_mesajlari.show',compact('item'));
    }
}
