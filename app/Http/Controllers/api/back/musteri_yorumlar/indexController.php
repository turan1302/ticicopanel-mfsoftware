<?php

namespace App\Http\Controllers\api\back\musteri_yorumlar;

use App\Http\Controllers\Controller;
use App\Models\MusteriYorumModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public $uploadFolder = "";
    public function __construct()
    {
        $this->uploadFolder = "musteriYorum";
    }

    public function index(){
        $query = MusteriYorumModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("my_sira", function ($query) {
                $query->orderBy("my_sira", "asc");
            })
            ->addColumn("my_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("my_durum", function ($query) {
                $checkedStatus = ($query->my_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->my_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("my_resim", function ($query) {
                if ($query->my_resim != "" && File::exists("storage/" . $query->my_resim)) {
                    $image = "<img src='" . asset('storage/' . $query->my_resim) . "' width='50' height='50'>";
                } else {
                    $image = "<img src='" . asset('storage/resim-yok.webp') . "' width='50' height='50'>";
                }

                return $image;
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.language.show', $query->dil_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.language.edit', $query->dil_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->dil_id'><i class='fa fa-times'></i> Sil</button>";

                return  $delete;
            })
            ->editColumn('my_dil_kod', function ($query) {
                return strtoupper($query->my_dil_kod);
            })
            ->rawColumns(["my_sira", "my_durum", 'my_dil_ikon', "actions"])
            ->make(true);

        return $data;
    }
}
