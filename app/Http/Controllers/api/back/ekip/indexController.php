<?php

namespace App\Http\Controllers\api\back\ekip;

use App\Helpers\myHelper;
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

        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('ekibimiz',"aktiflik")===false){
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
        if (myHelper::yetkiKontrol('ekibimiz',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

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
                $show = "<a href='" . route('back.ekip.show', $query->ekp_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> G??r??nt??le</a>";
                $edit = "<a href='" . route('back.ekip.edit', $query->ekp_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> G??ncelle</a>";
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

        if (myHelper::yetkiKontrol('ekibimiz',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

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
                    "text" => "2 MB Alt??nda  ve JPEG,JPG ve PNG Dosyas?? Y??kleyiniz",
                ];

                return response()->json($alert);
            }
        }

        $result = EkipModel::create($data);

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

    // GUNCELLEME SAYFASI AYARLANMASI
    public function edit(EkipModel $item){

        if (myHelper::yetkiKontrol('ekibimiz',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // GORUNTULEME KISMI
    public function show(EkipModel $item){

        if (myHelper::yetkiKontrol('ekibimiz',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // GUNCELLEME ISLEMI
    public function update(Request $request,EkipModel $item){

        if (myHelper::yetkiKontrol('ekibimiz',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

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

    // SIRALAMA KISMI AYARLANAMSI
    public function rankSetter(Request $request)
    {
        if (myHelper::yetkiKontrol('ekibimiz',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            EkipModel::where("ekp_id", $v)->update(array(
                "ekp_sira" => $k
            ));
        }
    }

    // AKTIF ??PASFO KISMI AYARLANSIM
    public function isActiveSetter(Request $request, EkipModel $item)
    {
        if (myHelper::yetkiKontrol('ekibimiz',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "ekp_durum" => $data
        ));
    }

    // DELETE KISMI AYARLANMASI
    public function delete(EkipModel $item)
    {
        if (myHelper::yetkiKontrol('ekibimiz',"silme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        if ($item->ekp_resim != "" && File::exists("storage/".$item->ekp_resim)){
            File::delete("storage/".$item->ekp_resim);
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
}
