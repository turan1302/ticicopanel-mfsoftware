<?php

namespace App\Http\Controllers\api\back\menuler;

use App\Http\Controllers\Controller;
use App\Models\MenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index(){
        $query = MenuModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("menu_sira", function ($query) {
                $query->orderBy("menu_sira", "asc");
            })
            ->addColumn("menu_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("menu_durum", function ($query) {
                $checkedStatus = ($query->menu_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->menu_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.ekip.show', $query->ekp_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.ekip.edit', $query->ekp_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->menu_id'><i class='fa fa-times'></i> Sil</button>";

                return $delete;
            })
            ->editColumn('menu_dil_kod', function ($query) {
                return strtoupper($query->menu_dil_kod);
            })
            ->rawColumns(["menu_sira", "menu_resim", "menu_durum", "actions"])
            ->make(true);

        return $data;
    }
}
