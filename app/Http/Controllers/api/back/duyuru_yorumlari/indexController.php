<?php

namespace App\Http\Controllers\api\back\duyuru_yorumlari;

use App\Http\Controllers\Controller;
use App\Models\DuyuruYorumlariModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index(){
        $query = DuyuruYorumlariModel::leftJoin("duyuru","duyuru.d_id","=","duyuru_yorumlar.dy_duyuru_id")->get();
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
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.duyurular.show', $query->d_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.duyurular.edit', $query->d_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->dy_id'><i class='fa fa-times'></i> Sil</button>";

                return $delete;
            })
            ->rawColumns(["dy_durum", "actions"])
            ->make(true);

        return $data;
    }
}
