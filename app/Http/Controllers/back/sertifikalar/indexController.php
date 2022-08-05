<?php

namespace App\Http\Controllers\back\sertifikalar;

use App\Http\Controllers\Controller;
use App\Models\SertifikaModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.sertifikalar.index');
    }

    // EKLEME KISMI
    public function create(){
        return view('back.sertifikalar.create');
    }

    // GUNCLELEME KISMI
    public function edit(SertifikaModel $item){
        return view('back.sertifikalar.edit',compact('item'));
    }

    // GORUNTULEME KISMI
    public function show(SertifikaModel $item){
        return view('back.sertifikalar.show',compact('item'));
    }
}
