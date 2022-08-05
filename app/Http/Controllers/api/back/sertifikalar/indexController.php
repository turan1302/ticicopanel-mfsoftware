<?php

namespace App\Http\Controllers\api\back\sertifikalar;

use App\Http\Controllers\Controller;
use App\Models\SertifikaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index(){
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
//                $show = "<a href='" . route('back.service.show', $query->service_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.service.edit', $query->service_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->sr_id'><i class='fa fa-times'></i> Sil</button>";
//
                return $delete;
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

    // SILME KISMI AYARLANMASI
    public function delete(SertifikaModel $item){
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
        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "sr_durum" => $data
        ));
    }

    // SIRALAMA KISMI AYARLANMASI
    public function rankSetter(Request $request){
        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            SertifikaModel::where("sr_id", $v)->update(array(
                "sr_sira" => $k
            ));
        }
    }
}
