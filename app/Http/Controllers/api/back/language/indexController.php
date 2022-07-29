<?php

namespace App\Http\Controllers\api\back\language;

use App\Http\Controllers\Controller;
use App\Models\LanguageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    // TUM DILLERI CEKME KISMI AYARLAMASI
    public function index()
    {
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
            ->addColumn("dil_durum", function ($query) {
                $checkedStatus = ($query->dil_varsayilan == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isDefault' data-id='$query->dil_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
                $edit = "<a href='' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $update = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->dil_id'><i class='fa fa-times'></i> Sil</button>";

                return $edit . " " . $update;
            })
            ->editColumn('dil_kod', function ($query) {
                return strtoupper($query->dil_kod);
            })
            ->rawColumns(["dil_sira", "dil_durum","dil_varsayilan", "actions"])
            ->make(true);

        return $data;
    }

    // DIL EKLEME KISMI APISINI YAZALIM
    public function store(Request $request)
    {
        $data = $request->except("_token");

        // AYNI KODDAN VAR MI ANALIZ EDELIM
        $sorgula = LanguageModel::where(array(
            "dil_kod" => $data['dil_kod']
        ))->first();

        $alert = [];
        if ($sorgula){
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "Aynı Dil Kodu Zaten Mevcut",
            ];

            return response()->json($alert);
        }

        // DOSYA GELDI MI
        $data['dil_ikon'] = "";

        if ($request->hasFile('dil_ikon')){
            $file = $request->file('dil_ikon');
            $desteklenen_uzantilar = ["jpeg","jpg","png"];
            if (in_array($file->getClientOriginalExtension(),$desteklenen_uzantilar)){
                $file_name = Str::slug($data['dil_ad'])."-".time().".".$file->getClientOriginalExtension();
                $data['dil_ikon'] = $file->storeAs("language",$file_name);
            }else{
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Altında  ve JPEG,JPG ve PNG Dosyası Yükleyiniz",
                ];

                return  response()->json($alert);
            }
        }

        $result = LanguageModel::create($data);

        if ($result){
            $alert = [
                "type" => "success",
                "title" => "Başarılı",
                "text" => "İşlem Başarılı",
            ];
        }else{
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "İşlem Başarısız",
            ];
        }

        return response()->json($alert);

    }

    // DIL SILME KISMI AYARLANMASINI GERCEKLESTIRELIM
    public function delete(LanguageModel $item){
        if ($item->dil_ikon!="" && File::exists("storage/".$item->dil_ikon)){
            File::delete("storage/".$item->dil_ikon);
        }

        $sonuc = $item->delete();
        if ($sonuc){
            $alert = [
                "type" => "success",
                "title" => "Başarılı",
                "text" => "İşlem Başarılı",
            ];
        }else{
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "İşlem Başarısız",
            ];
        }
        return response()->json($alert);
    }

    // AKTRIF PASIF OLAYINI DEGISTIRELIM
    public function isActiveSetter(Request $request,LanguageModel $item){
        $data = ($request->data=="true") ? 1 : 0;
        $item->update(array(
            "dil_durum" => $data
        ));
    }

    // DIL SIRALAMA GUNCELLEME KISMINI GERCEKLESTIRELIM
    public function rankSetter(Request $request)
    {
        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            LanguageModel::where("dil_id", $v)->update(array(
                "dil_sira" => $k
            ));
        }
    }
}
