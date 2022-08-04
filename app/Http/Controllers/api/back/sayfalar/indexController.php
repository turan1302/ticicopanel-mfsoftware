<?php

namespace App\Http\Controllers\api\back\sayfalar;

use App\Http\Controllers\Controller;
use App\Models\SayfaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public $uploadFolder = "";
    public function __construct()
    {
        $this->uploadFolder = "sayfa";
    }

    public function index(){
        $query = SayfaModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sayfa_id", function ($query) {
                $query->orderBy("sayfa_id", "desc");
            })
            ->addColumn("sayfa_resim", function ($query) {
                if ($query->sayfa_resim != "" && File::exists("storage/" . $query->sayfa_resim)) {
                    $image = "<img src='" . asset('storage/' . $query->sayfa_resim) . "' width='50' height='50'>";
                } else {
                    $image = "<img src='" . asset('storage/resim-yok.webp') . "' width='50' height='50'>";
                }

                return $image;
            })
            ->addColumn("sayfa_durum", function ($query) {
                $checkedStatus = ($query->sayfa_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->sayfa_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.menuler.show', $query->menu_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
                $edit = "<a href='" . route('back.sayfalar.edit', $query->sayfa_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->sayfa_id'><i class='fa fa-times'></i> Sil</button>";

                return $edit." ".$delete;
            })
            ->editColumn('sayfa_dil_kod', function ($query) {
                return strtoupper($query->sayfa_dil_kod);
            })
            ->rawColumns(["sayfa_resim", "sayfa_durum", "actions"])
            ->make(true);

        return $data;
    }

    // SAYFA EKLEME KISMI AYARLANAMSI
    public function store(Request $request){
        $data = $request->except("_token");

        $sorgu = SayfaModel::where(array(
            "sayfa_slug" => Str::slug($data['sayfa_baslik'])
        ))->first();

        if ($sorgu) {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "Aynı Sayfa Zaten Mevcut",
            ];

            return response()->json($alert);
        }

        // DOSYA GELDI MI
        $data['sayfa_resim'] = "";
        if ($request->hasFile('sayfa_resim')) {
            $file = $request->file('sayfa_resim');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {
                $file_name = Str::slug($data['sayfa_baslik']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['sayfa_resim'] = $file->storeAs($this->uploadFolder, $file_name);
            } else {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Altında  ve JPEG,JPG ve PNG Dosyası Yükleyiniz",
                ];

                return response()->json($alert);
            }
        }

        $result = SayfaModel::create($data);

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

    // GUNCELLEME KISMI
    public function edit(SayfaModel $item){
        return response()->json($item);
    }

    // GUNCELLEME ISLEMI
    public function update(Request $request,SayfaModel $item){
        $data = $request->except("_token");

        // SLUG KONTROL
        if ($data['sayfa_baslik'] != $item->sayfa_baslik){
            $sorgu = SayfaModel::where(array(
                "sayfa_slug" => Str::slug($data['sayfa_baslik'])
            ))->first();

            if ($sorgu) {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "Aynı Sayfa Zaten Mevcut",
                ];

                return response()->json($alert);
            }
        }


        // DOSYA GELDI MI
        $data['sayfa_resim'] = $item->sayfa_resim;
        if ($request->hasFile('sayfa_resim')) {
            $file = $request->file('sayfa_resim');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {

                // DOSYA GEREKTEN VAR ISE SILDIRELIM
                if ($item->sayfa_resim != "" && File::exists("storage/".$item->sayfa_resim)){
                    File::delete("storage/".$item->sayfa_resim);
                }

                $file_name = Str::slug($data['sayfa_baslik']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['sayfa_resim'] = $file->storeAs($this->uploadFolder, $file_name);
            } else {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Altında  ve JPEG,JPG ve PNG Dosyası Yükleyiniz",
                ];

                return response()->json($alert);
            }
        }

        $result = $item->update($data);

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

    // SILME KISMI AYARLANMASI
    public function delete(SayfaModel $item){
        if ($item->sayfa_resim != "" && File::exists("storage/".$item->sayfa_resim)){
             File::delete("storage/".$item->sayfa_resim);
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

    // AKTIF ĞPASFO KISMI AYARLANSIM
    public function isActiveSetter(Request $request, SayfaModel $item)
    {
        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "sayfa_durum" => $data
        ));
    }
}
