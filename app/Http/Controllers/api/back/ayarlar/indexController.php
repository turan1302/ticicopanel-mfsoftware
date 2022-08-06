<?php

namespace App\Http\Controllers\api\back\ayarlar;

use App\Http\Controllers\Controller;
use App\Mail\TopluMail;
use App\Models\AboneModel;
use App\Models\AyarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class indexController extends Controller
{
    public $logoFolder = "";
    public $faviconFolder = "";
    public function __construct()
    {
        $this->logoFolder = "ayar/logo";
        $this->faviconFolder = "ayar/favicon";
    }

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

    // LOGO GUNCELLEME KISMI AYARLAMASI
    public function logo_update(Request $request){
        $data = $request->except("_token");
        $ayar_cek = AyarModel::first();

        // DOSYA GELDI MI
        $data['site_icon'] = $ayar_cek->site_icon;
        if ($request->hasFile('site_icon')) {
            $file = $request->file('site_icon');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {

               // RESIM SILME KISMI AYARLANMASI GERCEKLESTIRELIM
                if ($ayar_cek->site_icon != "" && File::exists("storage/".$ayar_cek->site_icon)){
                    File::delete("storage/".$ayar_cek->site_icon);
                }

                $file_name = Str::slug($ayar_cek->site_baslik) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['site_icon'] = $file->storeAs($this->logoFolder, $file_name);
            } else {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Altında  ve JPEG,JPG ve PNG Dosyası Yükleyiniz",
                ];

                return response()->json($alert);
            }
        }

        $result = AyarModel::where(array())->update($data);

        if ($result) {
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


    // FAVICON KISMI GUNCELLEME ISLEMINI GERCEKLESTIRELIM
    public function favicon_update(Request $request){
        $data = $request->except("_token");
        $ayar_cek = AyarModel::first();

        // DOSYA GELDI MI
        $data['site_favicon'] = $ayar_cek->site_favicon;
        if ($request->hasFile('site_favicon')) {
            $file = $request->file('site_favicon');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {

                // RESIM SILME KISMI AYARLANMASI GERCEKLESTIRELIM
                if ($ayar_cek->site_favicon != "" && File::exists("storage/".$ayar_cek->site_favicon)){
                    File::delete("storage/".$ayar_cek->site_favicon);
                }

                $file_name = Str::slug($ayar_cek->site_baslik) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['site_favicon'] = $file->storeAs($this->faviconFolder, $file_name);
            } else {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Altında  ve JPEG,JPG ve PNG Dosyası Yükleyiniz",
                ];

                return response()->json($alert);
            }
        }

        $result = AyarModel::where(array())->update($data);

        if ($result) {
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

    // TOPLU MESAJ GONDERME KISMI AYARLANMASI
    public function toplu_mesaj_gonder(Request $request){
        $data = $request->except("_token");

        $aboneler = AboneModel::where("abone_durum", 1)->get();
        foreach ($aboneler as $abone) {
            Mail::to($abone->abone_email)->send(new TopluMail($data));
        }

        $alert = [
            "type" => "success",
            "title" => "Başarılı",
            "text" => "İşlem Başarılı",
        ];

        return response()->json($alert);
    }
}
