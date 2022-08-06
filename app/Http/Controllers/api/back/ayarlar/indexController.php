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

    // GUNCELLEME KISMI
    public function update(Request $request){
        $data = $request->except("_token");
        $sonuc = AyarModel::where(array())->update($data);

        if ($sonuc) {
            $alert = [
                "type" => "success",
                "title" => "Başarılı",
                "text" => "İşlem Başarılı",
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "İşlem Başarısız",
            ];
        }

        return response()->json($alert);
    }
}
