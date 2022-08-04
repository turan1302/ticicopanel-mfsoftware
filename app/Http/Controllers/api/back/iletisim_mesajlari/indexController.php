<?php

namespace App\Http\Controllers\api\back\iletisim_mesajlari;

use App\Http\Controllers\Controller;
use App\Models\IletisimMesajModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index(){
        $query = IletisimMesajModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("im_id", function ($query) {
                $query->orderBy("im_id", "desc");
            })
            ->addColumn("im_okundu_bilgisi", function ($query) {
                $color = ($query->im_okundu_bilgisi == 1) ? 'green' : 'red';
                return "<span class='material-icons' style='color: ".$color.";'>visibility</span>";
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.service.show', $query->service_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.service.edit', $query->service_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->im_id'><i class='fa fa-times'></i> Sil</button>";
//
                return $delete;
            })
            ->rawColumns(["im_okundu_bilgisi", "actions"])
            ->make(true);

        return $data;
    }

    // SILME KISMI AYARLANMASI
    public function delete(IletisimMesajModel $item){
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
