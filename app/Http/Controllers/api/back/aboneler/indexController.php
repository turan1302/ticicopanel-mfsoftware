<?php

namespace App\Http\Controllers\api\back\aboneler;

use App\Http\Controllers\Controller;
use App\Models\AboneModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index(){
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
//                $show = "<a href='" . route('back.service.show', $query->service_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.service.edit', $query->service_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->service_id'><i class='fa fa-times'></i> Sil</button>";
//
                return $delete;
            })
            ->rawColumns(["abone_durum", "actions"])
            ->make(true);

        return $data;
    }
}
