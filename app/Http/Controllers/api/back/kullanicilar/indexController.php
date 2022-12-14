<?php

namespace App\Http\Controllers\api\back\kullanicilar;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public $uploadFolder = "";

    public function __construct()
    {
        $this->uploadFolder = "avatar";

        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('kullanicilar',"aktiflik")===false){
                return redirect()->route('back.home.index')->with(array(
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "Yetkiniz Yok"
                ));
            }
            return $next($request);
        });
    }

    public function index()
    {
        if (myHelper::yetkiKontrol('kullanicilar',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $query = User::where("id", "!=", auth()->guard('yonetim')->id());
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("id", function ($query) {
                $query->orderBy("id", "desc");
            })
            ->addColumn("durum", function ($query) {
                $checkedStatus = ($query->durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
                $show = "<a href='" . route('back.kullanicilar.show', $query->id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
                $edit = "<a href='" . route('back.kullanicilar.edit', $query->id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->id'><i class='fa fa-times'></i> Sil</button>";
//
                return $show." ".$edit . " " . $delete;
            })
            ->rawColumns(["durum", "actions"])
            ->make(true);

        return $data;
    }

    // EKLEME KISMI AYARLANMASINI GERCEKLESTIRELIM
    public function store(Request $request)
    {

        if (myHelper::yetkiKontrol('kullanicilar',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");

        // EMAIL SORGUSU YAPALIM
        $sorgula = User::where(array(
            "email" => $data['email']
        ))->first();

        if ($sorgula) {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "Aynı Mail Adresi Zaten Mevcut",
            ];

            return response()->json($alert);
        }

        // DOSYA GELDI MI
        $data['avatar'] = "";
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {
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

        $data['password'] = Hash::make($data['password']);
        $sonuc = User::create($data);

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

    // GUNCELLEME KISMI AYARLANMASI
    public function edit(User $item)
    {
        if (myHelper::yetkiKontrol('kullanicilar',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // GORUNTULEME KISMI AYARLANMASI
    public function show(User $item){

        if (myHelper::yetkiKontrol('kullanicilar',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // GUNCELLEME ISLEMI
    public function update(Request $request,User $item)
    {
        if (myHelper::yetkiKontrol('kullanicilar',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");

        // SORGULAMA KSIMI AYARLANAMASI
        if ($data['email'] != $item->email){
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
        $data['avatar'] = $item->avatar;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {

                /** VAROLAN DOSYANIN SILINMEISNI AYARLAYUALIM **/
                if ($item->avatar != "" && File::exists("storage/".$item->avatar)){
                    File::delete("storage/".$item->avatar);
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

        $data['password'] = ($data['password'] != "") ? Hash::make($data['password']) : $item->password;
        $sonuc = $item->update($data);

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

    // SILME KISMI AYARLANMASI
    public function delete(User $item)
    {
        if (myHelper::yetkiKontrol('kullanicilar',"silme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        // AVATAR VARSA SILDIRELIM
        if ($item->avatar != "" && File::exists("storage/" . $item->avatar)) {
            File::delete("storage/" . $item->avatar);
        }

        $sonuc = $item->delete();

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

    // AKTIFLIK KISMI AYARLANMASI
    public function isActiveSetter(Request $request, User $item)
    {
        if (myHelper::yetkiKontrol('kullanicilar',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "durum" => $data
        ));
    }
}
