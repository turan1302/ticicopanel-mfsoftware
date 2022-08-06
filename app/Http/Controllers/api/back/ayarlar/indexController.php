<?php

namespace App\Http\Controllers\api\back\ayarlar;

use App\Http\Controllers\Controller;
use App\Models\AyarModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    // AYAR CEKME ISLEMI
    public function index(){
         $ayarlar = AyarModel::first();
        return response()->json($ayarlar);
    }
}
