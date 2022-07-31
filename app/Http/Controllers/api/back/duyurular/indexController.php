<?php

namespace App\Http\Controllers\api\back\duyurular;

use App\Http\Controllers\Controller;
use App\Models\DuyuruModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index(){
        $query = DuyuruModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("d_sira", function ($query) {
                $query->orderBy("d_sira", "asc");
            })
            ->addColumn("d_resim", function ($query) {
                if ($query->d_resim != "" && File::exists("storage/" . $query->d_resim)) {
                    $image = "<img src='" . asset('storage/' . $query->d_resim) . "' width='50' height='50'>";
                } else {
                    $image = "<img src='" . asset('storage/resim-yok.webp') . "' width='50' height='50'>";
                }

                return $image;
            })
            ->addColumn("d_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("d_durum", function ($query) {
                $checkedStatus = ($query->d_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->d_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.duyuru_kategoriler.show', $query->dkat_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.duyuru_kategoriler.edit', $query->dkat_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
//                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->dkat_id'><i class='fa fa-times'></i> Sil</button>";
//
//                return $show." ".$edit." ".$delete;
                return " ";
            })
            ->editColumn('d_dil_kod', function ($query) {
                return strtoupper($query->d_dil_kod);
            })
            ->rawColumns(["d_sira","d_resim", "d_durum", "actions"])
            ->make(true);

        return $data;
    }

    // AKTIF PASIF KISMI AYARLANAMSI
    public function isActiveSetter(Request $request, DuyuruModel $item)
    {
        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "d_durum" => $data
        ));
    }
}
