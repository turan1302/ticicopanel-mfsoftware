<?php

namespace App\Http\Controllers\api\back\service;

use App\Http\Controllers\Controller;
use App\Models\ServiceModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    // SERVISLERI CAGIRALIM
    public function index(){
        $query = ServiceModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("service_sira", function ($query) {
                $query->orderBy("service_sira", "asc");
            })
            ->addColumn("service_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("service_durum", function ($query) {
                $checkedStatus = ($query->service_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->service_durum' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.language.show', $query->dil_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.language.edit', $query->dil_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
//                $update = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->dil_id'><i class='fa fa-times'></i> Sil</button>";
//
//                return $show." ".$edit . " " . $update;
                return "";
            })
            ->editColumn('service_dil_kod', function ($query) {
                return strtoupper($query->service_dil_kod);
            })
            ->rawColumns(["service_sira", "service_durum", "actions"])
            ->make(true);

        return $data;
    }

    // SERVIS GUNCELLEME KSIMININ AYARLANMASINI GERCEKLESTIRELIM
    public function isActiveSetter(Request $request,ServiceModel $item){
        $data = ($request->data=="true") ? 1 : 0;
        $item->update(array(
            "service_durum" => $data
        ));
    }

    // SERVIS SIRALAMA GUNCELLEME
    public function rankSetter(Request $request)
    {
        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            ServiceModel::where("service_id", $v)->update(array(
                "service_sira" => $k
            ));
        }
    }
}
