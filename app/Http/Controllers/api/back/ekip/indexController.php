<?php

namespace App\Http\Controllers\api\back\ekip;

use App\Http\Controllers\Controller;
use App\Models\EkipModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public $uploadFolder = "";
    public function __construct()
    {
        $this->uploadFolder = "ekip";
    }

    public function index()
    {
        $query = EkipModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("ekp_sira", function ($query) {
                $query->orderBy("ekp_sira", "asc");
            })
            ->addColumn("ekp_resim", function ($query) {
                if ($query->ekp_resim != "" && File::exists("storage/" . $query->ekp_resim)) {
                    $image = "<img src='" . asset('storage/' . $query->ekp_resim) . "' width='50' height='50'>";
                } else {
                    $image = "<img src='" . asset('storage/resim-yok.webp') . "' width='50' height='50'>";
                }

                return $image;
            })
            ->addColumn("ekp_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("ekp_durum", function ($query) {
                $checkedStatus = ($query->ekp_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->ekp_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
                $show = "<a href='" . route('back.ekip.show', $query->ekp_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
                $edit = "<a href='" . route('back.ekip.edit', $query->ekp_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->ekp_id'><i class='fa fa-times'></i> Sil</button>";

                return  $show." ".$edit." ".$delete;
            })
            ->editColumn('ekp_dil_kod', function ($query) {
                return strtoupper($query->ekp_dil_kod);
            })
            ->rawColumns(["ekp_sira", "ekp_resim", "ekp_durum", "actions"])
            ->make(true);

        return $data;
    }

    // EKLEME ISLEMI
    public function store(Request $request){
        $data = $request->except("_token");

        // DOSYTA GELDI MI
        $data['ekp_resim'] = "";
        if ($request->hasFile('ekp_resim')) {
            $file = $request->file('ekp_resim');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {
                $file_name = Str::slug($data['ekp_adsoyad']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['ekp_resim'] = $file->storeAs($this->uploadFolder, $file_name);
            } else {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Altında  ve JPEG,JPG ve PNG Dosyası Yükleyiniz",
                ];

                return response()->json($alert);
            }
        }

        $result = EkipModel::create($data);

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

    // GUNCELLEME SAYFASI AYARLANMASI
    public function edit(EkipModel $item){
        return response()->json($item);
    }

    // GORUNTULEME KISMI
    public function show(EkipModel $item){
        return response()->json($item);
    }

    // GUNCELLEME ISLEMI
    public function update(Request $request,EkipModel $item){
        $data = $request->except("_token");

        $data['ekp_resim'] = $item->ekp_resim;
        if ($request->hasFile('ekp_resim')) {
            $file = $request->file('ekp_resim');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {

               // RESIM SILDIRELIM
                if ($item->ekp_resim != "" && File::exists("storage/".$item->ekp_resim)){
                    File::delete("storage/".$item->ekp_resim);
                }

                $file_name = Str::slug($data['ekp_adsoyad']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['ekp_resim'] = $file->storeAs($this->uploadFolder, $file_name);
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

    // SIRALAMA KISMI AYARLANAMSI
    public function rankSetter(Request $request)
    {
        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            EkipModel::where("ekp_id", $v)->update(array(
                "ekp_sira" => $k
            ));
        }
    }

    // AKTIF ĞPASFO KISMI AYARLANSIM
    public function isActiveSetter(Request $request, EkipModel $item)
    {
        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "ekp_durum" => $data
        ));
    }

    // DELETE KISMI AYARLANMASI
    public function delete(EkipModel $item)
    {
        if ($item->ekp_resim != "" && File::exists("storage/".$item->ekp_resim)){
            File::delete("storage/".$item->ekp_resim);
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
}
