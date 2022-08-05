<?php

namespace App\Http\Controllers\api\back\kullanicilar;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index(){
        $query = User::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("id", function ($query) {
                $query->orderBy("id", "desc");
            })
            ->addColumn("durum", function ($query) {
                $checkedStatus = ($query->durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.service.show', $query->service_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.service.edit', $query->service_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->id'><i class='fa fa-times'></i> Sil</button>";
//
                return $delete;
            })
            ->rawColumns(["durum", "actions"])
            ->make(true);

        return $data;
    }
}
