<?php

namespace App\Http\Controllers\api\back\language;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\LanguageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public $uploadFolder = "";

    public function __construct()
    {
        $this->uploadFolder = "language";

        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('diller',"aktiflik")===false){
                return redirect()->route('back.home.index')->with(array(
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "Yetkiniz Yok"
                ));
            }
            return $next($request);
        });

    }

    // TUM DILLERI CEKME KISMI AYARLAMASI
    public function index()
    {
        if (myHelper::yetkiKontrol('diller',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $query = LanguageModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("dil_sira", function ($query) {
                $query->orderBy("dil_sira", "asc");
            })
            ->addColumn("dil_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("dil_durum", function ($query) {
                $checkedStatus = ($query->dil_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->dil_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("dil_varsayilan", function ($query) {
                $checkedStatus = ($query->dil_varsayilan == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isDefault' data-id='$query->dil_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("dil_ikon", function ($query) {
                if ($query->dil_ikon != "" && File::exists("storage/" . $query->dil_ikon)) {
                    $image = "<img src='" . asset('storage/' . $query->dil_ikon) . "' width='50' height='50'>";
                } else {
                    $image = "<img src='" . asset('storage/resim-yok.webp') . "' width='50' height='50'>";
                }

                return $image;
            })
            ->addColumn("actions", function ($query) {
                $show = "<a href='" . route('back.language.show', $query->dil_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> G??r??nt??le</a>";
                $edit = "<a href='" . route('back.language.edit', $query->dil_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> G??ncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->dil_id'><i class='fa fa-times'></i> Sil</button>";

                return $show." ".$edit . " " . $delete;
            })
            ->editColumn('dil_kod', function ($query) {
                return strtoupper($query->dil_kod);
            })
            ->rawColumns(["dil_sira", "dil_durum", "dil_varsayilan", 'dil_ikon', "actions"])
            ->make(true);

        return $data;
    }

    // DIL EKLEME KISMI APISINI YAZALIM
    public function store(Request $request)
    {

        if (myHelper::yetkiKontrol('diller',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");

        // AYNI KODDAN VAR MI ANALIZ EDELIM
        $sorgula = LanguageModel::where(array(
            "dil_kod" => $data['dil_kod']
        ))->first();

        if ($sorgula) {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "Ayn?? Dil Kodu Zaten Mevcut",
            ];

            return response()->json($alert);
        }

        // DOSYA GELDI MI
        $data['dil_ikon'] = "";

        if ($request->hasFile('dil_ikon')) {
            $file = $request->file('dil_ikon');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {
                $file_name = Str::slug($data['dil_ad']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['dil_ikon'] = $file->storeAs($this->uploadFolder, $file_name);
            } else {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Alt??nda  ve JPEG,JPG ve PNG Dosyas?? Y??kleyiniz",
                ];

                return response()->json($alert);
            }
        }

        $result = LanguageModel::create($data);

        if ($result) {
            $alert = [
                "type" => "success",
                "title" => "Ba??ar??l??",
                "text" => "????lem Ba??ar??l??",
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "????lem Ba??ar??s??z",
            ];
        }

        return response()->json($alert);

    }

    // DIL GETIRME ISLEMININ GERCEKLESTIRELIM
    public function edit(LanguageModel $item)
    {
        if (myHelper::yetkiKontrol('diller',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // DIL GORUNTULEME KISMI
    public function show(LanguageModel $item)
    {
        if (myHelper::yetkiKontrol('diller',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // DIL GUNCELLEME ISLEMINI GERCEKLESTIRELIM
    public function update(Request $request, LanguageModel $item)
    {
        if (myHelper::yetkiKontrol('diller',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");

        if ($request->dil_kod != $item->dil_kod) {
            // AYNI KODDAN VAR MI ANALIZ EDELIM
            $sorgula = LanguageModel::where(array(
                "dil_kod" => $data['dil_kod']
            ))->first();

            if ($sorgula) {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "Ayn?? Dil Kodu Zaten Mevcut",
                ];

                return response()->json($alert);

            }
        }


        // DOSYA GELDI MI
        $data['dil_ikon'] = $item->dil_ikon;

        if ($request->hasFile('dil_ikon')) {
            $file = $request->file('dil_ikon');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];

            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {

                // ONCEKI DOSYAYI BI SILDIRELIM
                if ($item->dil_ikon != "" && File::exists("storage/" . $item->dil_ikon)) {
                    File::delete("storage/" . $item->dil_ikon);
                }

                $file_name = Str::slug($data['dil_ad']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['dil_ikon'] = $file->storeAs($this->uploadFolder, $file_name);
            } else {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Alt??nda  ve JPEG,JPG ve PNG Dosyas?? Y??kleyiniz",
                ];

                return response()->json($alert);
            }
        }


        $result = $item->update($data);

        if ($result) {
            $alert = [
                "type" => "success",
                "title" => "Ba??ar??l??",
                "text" => "????lem Ba??ar??l??",
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "????lem Ba??ar??s??z",
            ];
        }

        return response()->json($alert);

    }

    // DIL SILME KISMI AYARLANMASINI GERCEKLESTIRELIM
    public function delete(LanguageModel $item)
    {
        if (myHelper::yetkiKontrol('diller',"silme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        if ($item->dil_ikon != "" && File::exists("storage/" . $item->dil_ikon)) {
            File::delete("storage/" . $item->dil_ikon);
        }

        $sonuc = $item->delete();
        if ($sonuc) {
            $alert = [
                "type" => "success",
                "title" => "Ba??ar??l??",
                "text" => "????lem Ba??ar??l??",
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "????lem Ba??ar??s??z",
            ];
        }
        return response()->json($alert);
    }

    // AKTRIF PASIF OLAYINI DEGISTIRELIM
    public function isActiveSetter(Request $request, LanguageModel $item)
    {
        if (myHelper::yetkiKontrol('diller',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "dil_durum" => $data
        ));
    }

    // DEFAULT OLARAK SECILME ISLEMINI GERCEKLESTIRELIM
    public function isDefaultSetter(Request $request, LanguageModel $item)
    {
        if (myHelper::yetkiKontrol('diller',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = ($request->data == "true") ? 1 : 0;

        LanguageModel::where(array())->update(array(
            "dil_varsayilan" => 0
        ));

        $item->update(array(
            "dil_varsayilan" => 1
        ));
    }

    // DIL SIRALAMA GUNCELLEME KISMINI GERCEKLESTIRELIM
    public function rankSetter(Request $request)
    {
        if (myHelper::yetkiKontrol('diller',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            LanguageModel::where("dil_id", $v)->update(array(
                "dil_sira" => $k
            ));
        }
    }
}
