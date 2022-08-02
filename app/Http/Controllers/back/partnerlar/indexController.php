<?php

namespace App\Http\Controllers\back\partnerlar;

use App\Http\Controllers\Controller;
use App\Models\PartnerModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.partnerlar.index');
    }

    // EKLEME SAYAFSI
    public function create(){
        return view('back.partnerlar.create');
    }

    // GUNCELLEME SAYFASI
    public function edit(PartnerModel $item){
        return view('back.partnerlar.edit',compact('item'));
    }

    // GORUNTULEME SAYFASI KISMI
    public function show(PartnerModel $item){
        return view('back.partnerlar.show',compact('item'));
    }

}
