<?php

namespace App\Http\Controllers\api\back\duyuru_yorumlari;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\DuyuruYorumlariModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('duyuru_yorumlar',"aktiflik")===false){
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
        if (myHelper::yetkiKontrol('duyuru_yorumlar',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $query = DuyuruYorumlariModel::select(["duyurular.*", "duyuru_yorumlar.*"])->leftJoin("duyurular", "duyurular.d_id", "=", "duyuru_yorumlar.dy_duyuru_id");
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("dy_id", function ($query) {
                $query->orderBy("dy_id", "desc");
            })
            ->addColumn("dy_durum", function ($query) {
                $checkedStatus = ($query->dy_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->dy_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("duyuru", function ($query) {
                return $query->d_baslik;
            })
            ->addColumn("actions", function ($query) {
                $edit = "<a href='" . route('back.duyuru_yorumlar.edit', $query->dy_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> G??r??nt??le</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->dy_id'><i class='fa fa-times'></i> Sil</button>";

                return $edit." ".$delete;
            })
            ->rawColumns(["dy_durum", "actions"])
            ->make(true);

        return $data;
    }

    // GORUNTULEME SAYFASI (EDIT KISMI)
    public function edit(DuyuruYorumlariModel $item){

        if (myHelper::yetkiKontrol('duyuru_yorumlar',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $item->update(array(
            "dy_okunma" => 1
        ));

        $item = DuyuruYorumlariModel::leftJoin("duyurular","duyurular.d_id","=","duyuru_yorumlar.dy_duyuru_id")->first();

        return response()->json($item);
    }

    // CEVAPLAMA KISMI AYARLANAMSI
    public function cevapla(Request $request,DuyuruYorumlariModel $item){

        if (myHelper::yetkiKontrol('duyuru_yorumlar',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $sonuc = DuyuruYorumlariModel::create(array(
            "dy_adsoyad" => env("APP_NAME"),
            "dy_yorum" => $request->yorumunuz,
            "dy_duyuru_id" => $item->dy_duyuru_id,
            "dy_okunma" => 1,
            "dy_durum" => 1,
            "dy_yorum_ust" => $item->dy_id,
            "dy_ip" => $request->getClientIp()
        ));

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

    // SILME KISMI AYARLANAMSI
    public function delete(DuyuruYorumlariModel $item){

        if (myHelper::yetkiKontrol('duyuru_yorumlar',"silme")===false){
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

    // IS ACTIVE KISMI AYARLANMASI GERCEKLESTIRELIM
    public function isActiveSetter(Request $request,DuyuruYorumlariModel $item){

        if (myHelper::yetkiKontrol('duyuru_yorumlar',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "dy_durum" => $data
        ));
    }
}
