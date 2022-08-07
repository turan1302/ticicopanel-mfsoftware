<?php

namespace App\Http\Controllers\api\back\profil;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class indexController extends Controller
{
    public $uploadFolder = "";
    public function __construct()
    {
        $this->uploadFolder = "avatar";
    }

    public function index(){
        $user = auth()->guard('yonetim')->user();
        return response()->json($user);
    }

    //  GUNCELLEME KISMI
    public function update(Request $request){
        $data = $request->except("_token");
        $aktif_kullanici = auth()->guard('yonetim')->user();

        // SORGULAMA KSIMI AYARLANAMASI
        if ($data['email'] != $aktif_kullanici->email){
            $sorgula = User::where(array(
                "email" => $data['email']
            ))->first();

            if ($sorgula){
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "Aynı Mail Adresi Zaten Mevcut",
                ];

                return response()->json($alert);
            }
        }


        // DOSYA GELDI MI
        $data['avatar'] = $aktif_kullanici->avatar;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {

                /** VAROLAN DOSYANIN SILINMEISNI AYARLAYUALIM **/
                if ($aktif_kullanici->avatar != "" && File::exists("storage/".$aktif_kullanici->avatar)){
                    File::delete("storage/".$aktif_kullanici->avatar);
                }

                $file_name = Str::slug($data['name']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['avatar'] = $file->storeAs($this->uploadFolder, $file_name);
            } else {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Altında  ve JPEG,JPG ve PNG Dosyası Yükleyiniz",
                ];

                return response()->json($alert);
            }
        }

        $data['password'] = ($data['password'] != "") ? Hash::make($data['password']) : $aktif_kullanici->password;
        $sonuc = User::where(array(
            "id" => $aktif_kullanici->id
        ))->update($data);

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
