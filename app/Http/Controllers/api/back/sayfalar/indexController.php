<?php

namespace App\Http\Controllers\api\back\sayfalar;

use App\Http\Controllers\Controller;
use App\Models\SayfaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index(){
        $query = SayfaModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sayfa_id", function ($query) {
                $query->orderBy("sayfa_id", "desc");
            })
            ->addColumn("sayfa_resim", function ($query) {
                if ($query->sayfa_resim != "" && File::exists("storage/" . $query->sayfa_resim)) {
                    $image = "<img src='" . asset('storage/' . $query->sayfa_resim) . "' width='50' height='50'>";
                } else {
                    $image = "<img src='" . asset('storage/resim-yok.webp') . "' width='50' height='50'>";
                }

                return $image;
            })
            ->addColumn("sayfa_durum", function ($query) {
                $checkedStatus = ($query->sayfa_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->sayfa_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.menuler.show', $query->menu_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.menuler.edit', $query->menu_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->sayfa_id'><i class='fa fa-times'></i> Sil</button>";

                return $delete;
            })
            ->editColumn('sayfa_dil_kod', function ($query) {
                return strtoupper($query->sayfa_dil_kod);
            })
            ->rawColumns(["sayfa_resim", "sayfa_durum", "actions"])
            ->make(true);

        return $data;
    }
}
