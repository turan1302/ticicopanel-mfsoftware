<?php

namespace App\Http\Controllers\api\back\duyuru_yorumlari;

use App\Http\Controllers\Controller;
use App\Models\DuyuruYorumlariModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
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
//                $show = "<a href='" . route('back.duyurular.show', $query->d_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
                $edit = "<a href='" . route('back.duyuru_yorumlar.edit', $query->dy_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->dy_id'><i class='fa fa-times'></i> Sil</button>";

                return $edit." ".$delete;
            })
            ->rawColumns(["dy_durum", "actions"])
            ->make(true);

        return $data;
    }

    // GORUNTULEME SAYFASI (EDIT KISMI)
    public function edit(DuyuruYorumlariModel $item){
        $item->update(array(
            "dy_okunma" => 1
        ));

        return response()->json($item);
    }

    // SILME KISMI AYARLANAMSI
    public function delete(DuyuruYorumlariModel $item){

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

    // IS ACTIVE KISMI AYARLANMASI GERCEKLESTIRELIM
    public function isActiveSetter(Request $request,DuyuruYorumlariModel $item){
        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "dy_durum" => $data
        ));
    }
}
