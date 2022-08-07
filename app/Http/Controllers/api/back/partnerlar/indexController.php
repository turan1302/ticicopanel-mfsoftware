<?php

namespace App\Http\Controllers\api\back\partnerlar;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\PartnerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public $uploadFolder = "";

    public function __construct()
    {
        $this->uploadFolder = "partner";

        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('partnerler',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('partnerler',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $query = PartnerModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("part_sira", function ($query) {
                $query->orderBy("part_sira", "asc");
            })
            ->addColumn("part_resim", function ($query) {
                if ($query->part_resim != "" && File::exists("storage/" . $query->part_resim)) {
                    $image = "<img src='" . asset('storage/' . $query->part_resim) . "' width='50' height='50'>";
                } else {
                    $image = "<img src='" . asset('storage/resim-yok.webp') . "' width='50' height='50'>";
                }

                return $image;
            })
            ->addColumn("part_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("part_durum", function ($query) {
                $checkedStatus = ($query->part_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->part_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
                $show = "<a href='" . route('back.partnerlar.show', $query->part_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
                $edit = "<a href='" . route('back.partnerlar.edit', $query->part_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->part_id'><i class='fa fa-times'></i> Sil</button>";

                return $show." ".$edit . " " . $delete;
            })
            ->editColumn('part_dil_kod', function ($query) {
                return strtoupper($query->part_dil_kod);
            })
            ->rawColumns(["part_sira", "part_resim", "part_durum", "actions"])
            ->make(true);

        return $data;
    }

    // EKLEME ISLEMI
    public function store(Request $request)
    {
        if (myHelper::yetkiKontrol('partnerler',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");

        $sorgu = PartnerModel::where(array(
            "part_slug" => Str::slug($data['part_baslik'])
        ))->first();

        if ($sorgu) {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "Aynı Partner Zaten Mevcut",
            ];

            return response()->json($alert);
        }

        // DOSYA GELDI MI
        $data['part_resim'] = "";
        if ($request->hasFile('part_resim')) {
            $file = $request->file('part_resim');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {
                $file_name = Str::slug($data['part_baslik']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['part_resim'] = $file->storeAs($this->uploadFolder, $file_name);
            } else {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Altında  ve JPEG,JPG ve PNG Dosyası Yükleyiniz",
                ];

                return response()->json($alert);
            }
        }

        $result = PartnerModel::create($data);

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

    // GUNCELLEME SAYFASI AYARLANAMSI
    public function edit(PartnerModel $item)
    {
        if (myHelper::yetkiKontrol('partnerler',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // GORUNTULEME KISMI AYARLANAMSINI GERCEKLESRTIRELIM
    public function show(PartnerModel $item){

        if (myHelper::yetkiKontrol('partnerler',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }


    // GUNCELLEME ISLEMI
    public function update(Request $request, PartnerModel $item)
    {
        if (myHelper::yetkiKontrol('partnerler',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");

        if ($data['part_baslik'] != $item->part_baslik) {
            $sorgu = PartnerModel::where(array(
                "part_slug" => Str::slug($data['part_baslik'])
            ))->first();

            if ($sorgu) {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "Aynı Partner Zaten Mevcut",
                ];
                return response()->json($alert);
            }
        }

        // DOSYA GELDI MI
        $data['part_resim'] = $item->part_resim;
        if ($request->hasFile('part_resim')) {
            $file = $request->file('part_resim');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {

                /** RESIM GERCEKTEN VAR MI **/
                if ($item->part_resim != "" && File::exists("storage/".$item->part_resim)){
                    File::delete("storage/".$item->part_resim);
                }

                $file_name = Str::slug($data['part_baslik']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['part_resim'] = $file->storeAs($this->uploadFolder, $file_name);
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

    // SILME KISMI AYARLANAMSI
    public function delete(PartnerModel $item)
    {
        if (myHelper::yetkiKontrol('partnerler',"silme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        if ($item->part_resim != "" && File::exists("storage/" . $item->part_resim)) {
            File::delete("storage/" . $item->part_resim);
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

    // AKTIF PASIFLIK AYARLAMASI YAPALIM
    public function isActiveSetter(Request $request, PartnerModel $item)
    {
        if (myHelper::yetkiKontrol('partnerler',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "part_durum" => $data
        ));
    }

    // SIRALAMA KISMI AYARLANMASINI GERCEKLESTIRELIM
    public function rankSetter(Request $request)
    {
        if (myHelper::yetkiKontrol('partnerler',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            PartnerModel::where("part_id", $v)->update(array(
                "part_sira" => $k
            ));
        }
    }
}
