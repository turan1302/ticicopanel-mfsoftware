<?php

namespace App\Http\Controllers\api\back\ekip;

use App\Http\Controllers\Controller;
use App\Models\EkipModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index(){
        $query = EkipModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("ekp_sira", function ($query) {
                $query->orderBy("ekp_sira", "asc");
            })
            ->addColumn("ekp_resim", function ($query) {
                if ($query->ekp_resim != "" && File::exists("storage/" . $query->ekp_resim)) {
                    $image = "<img src='" . asset('storage/' . $query->ekp_resim) . "' width='50' height='50'>";
                } else {
                    $image = "<img src='" . asset('storage/resim-yok.webp') . "' width='50' height='50'>";
                }

                return $image;
            })
            ->addColumn("ekp_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("ekp_durum", function ($query) {
                $checkedStatus = ($query->ekp_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->ekp_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.partnerlar.show', $query->part_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.partnerlar.edit', $query->part_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->ekp_id'><i class='fa fa-times'></i> Sil</button>";

                return $delete;
            })
            ->editColumn('ekp_dil_kod', function ($query) {
                return strtoupper($query->ekp_dil_kod);
            })
            ->rawColumns(["ekp_sira", "ekp_resim", "ekp_durum", "actions"])
            ->make(true);

        return $data;
    }

    // SIRALAMA KISMI AYARLANAMSI
    public function rankSetter(Request $request)
    {
        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            EkipModel::where("ekp_id", $v)->update(array(
                "ekp_sira" => $k
            ));
        }
    }
}
