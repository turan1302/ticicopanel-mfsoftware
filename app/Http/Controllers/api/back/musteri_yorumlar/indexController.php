<?php

namespace App\Http\Controllers\api\back\musteri_yorumlar;

use App\Http\Controllers\Controller;
use App\Models\MusteriYorumModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public $uploadFolder = "";

    public function __construct()
    {
        $this->uploadFolder = "musteriYorum";
    }

    public function index()
    {
        $query = MusteriYorumModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("my_sira", function ($query) {
                $query->orderBy("my_sira", "asc");
            })
            ->addColumn("my_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("my_durum", function ($query) {
                $checkedStatus = ($query->my_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->my_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("my_resim", function ($query) {
                if ($query->my_resim != "" && File::exists("storage/" . $query->my_resim)) {
                    $image = "<img src='" . asset('storage/' . $query->my_resim) . "' width='50' height='50'>";
                } else {
                    $image = "<img src='" . asset('storage/resim-yok.webp') . "' width='50' height='50'>";
                }

                return $image;
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.language.show', $query->dil_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
                $edit = "<a href='" . route('back.musteri_yorumlar.edit', $query->my_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->my_id'><i class='fa fa-times'></i> Sil</button>";

                return $edit." ".$delete;
            })
            ->editColumn('my_dil_kod', function ($query) {
                return strtoupper($query->my_dil_kod);
            })
            ->rawColumns(["my_sira", "my_durum", "my_resim", 'my_dil_ikon', "actions"])
            ->make(true);

        return $data;
    }

    // EKLEME KISMI
    public function store(Request $request){
        $data = $request->except("_token");

        // DOSYA GELDI MI
        $data['my_resim'] = "";
        if ($request->hasFile('my_resim')) {
            $file = $request->file('my_resim');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {
                $file_name = Str::slug($data['my_adsoyad']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['my_resim'] = $file->storeAs($this->uploadFolder, $file_name);
            } else {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Altında  ve JPEG,JPG ve PNG Dosyası Yükleyiniz",
                ];

                return response()->json($alert);
            }
        }

        $result = MusteriYorumModel::create($data);

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

    // GUNCELLEME KISMI AYARLANMASI
    public function edit(MusteriYorumModel $item){
        return response()->json($item);
    }

    // GUNCELLEME ISLEMI AYARLANMASI
    public function update(Request $request,MusteriYorumModel $item){
        $data = $request->except("_token");

        // DOSYA GELDI MI
        $data['my_resim'] = $item->my_resim;
        if ($request->hasFile('my_resim')) {
            $file = $request->file('my_resim');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {

                // DOSYA CIDDEN VARSA SILDIRELIM
                if ($item->my_resim != "" && File::exists("storage/".$item->my_resim)){
                    File::delete("storage/".$item->my_resim);
                }

                $file_name = Str::slug($data['my_adsoyad']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['my_resim'] = $file->storeAs($this->uploadFolder, $file_name);
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
    public function delete(MusteriYorumModel $item){
        if ($item->my_resim != "" && File::exists("storage/".$item->my_resim)){
            File::delete("storage/".$item->my_resim);
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

    // AKTIF PASIF KISMI AYARLANMASI
    public function isActiveSetter(Request $request,MusteriYorumModel $item){
        $data = ($request->data=="true") ? 1 : 0;
        $item->update(array(
            "my_durum" => $data
        ));
    }

    // SIRALAMA KISMI AYARLANMASI
    public function rankSetter(Request $request){
        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            MusteriYorumModel::where("my_id", $v)->update(array(
                "my_sira" => $k
            ));
        }
    }
}
