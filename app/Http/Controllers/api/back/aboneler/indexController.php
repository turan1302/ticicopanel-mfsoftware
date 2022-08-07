<?php

namespace App\Http\Controllers\api\back\aboneler;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\AboneModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('aboneler',"aktiflik")===false){
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

        if (myHelper::yetkiKontrol('aboneler',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $query = AboneModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("abone_id", function ($query) {
                $query->orderBy("abone_id", "desc");
            })
            ->addColumn("abone_durum", function ($query) {
                $checkedStatus = ($query->abone_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->abone_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->abone_id'><i class='fa fa-times'></i> Sil</button>";
                return $delete;
            })
            ->rawColumns(["abone_durum", "actions"])
            ->make(true);

        return $data;
    }

    // EKLEME KISMI
    public function store(Request $request){

        if (myHelper::yetkiKontrol('aboneler',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");

        $sorgu = AboneModel::where(array(
            "abone_email" => $data['abone_email']
        ))->first();

        if ($sorgu) {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "Aynı Mail Adresi Zaten Mevcut",
            ];

            return response()->json($alert);
        }

        $result = AboneModel::create($data);

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

    // SILME KISMI AYARLAMASI
    public function delete(AboneModel $item){

        if (myHelper::yetkiKontrol('aboneler',"silme")===false){
            return redirect()->route('back.home.index')->with(array(
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
    public function isActiveSetter(Request $request, AboneModel $item)
    {
        if (myHelper::yetkiKontrol('aboneler',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "abone_durum" => $data
        ));
    }
}
