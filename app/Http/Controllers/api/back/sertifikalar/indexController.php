<?php

namespace App\Http\Controllers\api\back\sertifikalar;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\SertifikaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('sertifikalar',"aktiflik")===false){
                return redirect()->route('back.home.index')->with(array(
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "Yetkiniz Yok"
                ));
            }
            return $next($request);
        });
    }

    public function index(){

        if (myHelper::yetkiKontrol('sertifikalar',"listeleme")===false){
            return redirect()->route('back.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $query = SertifikaModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sr_sira", function ($query) {
                $query->orderBy("sr_sira", "asc");
            })
            ->addColumn("sr_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("sr_durum", function ($query) {
                $checkedStatus = ($query->sr_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->sr_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
                $show = "<a href='" . route('back.sertifikalar.show', $query->sr_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
                $edit = "<a href='" . route('back.sertifikalar.edit', $query->sr_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->sr_id'><i class='fa fa-times'></i> Sil</button>";

                return $show." ".$edit." ".$delete;
            })
            ->editColumn('sr_dil_kod', function ($query) {
                return strtoupper($query->sr_dil_kod);
            })
            ->rawColumns(["sr_sira", "sr_durum", "actions"])
            ->make(true);

        return $data;
    }

    // EKLEME KISMI AYARLANMASI
    public function store(Request $request){

        if (myHelper::yetkiKontrol('sertifikalar',"ekleme")===false){
            return redirect()->route('back.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");
        $result = SertifikaModel::create($data);

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

    // GUNCELLEME KISMI AYARLANAMSI
    public function edit(SertifikaModel $item){

        if (myHelper::yetkiKontrol('sertifikalar',"guncelleme")===false){
            return redirect()->route('back.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // GORUNTULEME KISMI AYARLANMASI
    public function show(SertifikaModel $item){

        if (myHelper::yetkiKontrol('sertifikalar',"goruntuleme")===false){
            return redirect()->route('back.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // GUNCELLEME KISMI
    public function update(Request $request,SertifikaModel $item){

        if (myHelper::yetkiKontrol('sertifikalar',"guncelleme")===false){
            return redirect()->route('back.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");
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
    public function delete(SertifikaModel $item){

        if (myHelper::yetkiKontrol('sertifikalar',"silme")===false){
            return redirect()->route('back.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
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

    // AKTIF PASIF KISMI AYARLAMASI
    public function isActiveSetter(Request $request, SertifikaModel $item)
    {
        if (myHelper::yetkiKontrol('sertifikalar',"guncelleme")===false){
            return redirect()->route('back.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "sr_durum" => $data
        ));
    }

    // SIRALAMA KISMI AYARLANMASI
    public function rankSetter(Request $request){

        if (myHelper::yetkiKontrol('sertifikalar',"guncelleme")===false){
            return redirect()->route('back.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            SertifikaModel::where("sr_id", $v)->update(array(
                "sr_sira" => $k
            ));
        }
    }
}
