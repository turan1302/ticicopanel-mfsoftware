<?php

namespace App\Http\Controllers\api\back\language;

use App\Http\Controllers\Controller;
use App\Models\LanguageModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    // TUM DILLERI CEKME KISMI AYARLAMASI
    public function index()
    {
        $query = LanguageModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("dil_sira",function ($query){
                $query->orderBy("dil_sira", "asc");
            })
            ->addColumn("dil_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("dil_durum", function ($query) {
                $checkedStatus = ($query->dil_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("dil_durum", function ($query) {
                $edit = "<a href='' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>";
                $update = "<button type='button' class='btn btn-danger btn-sm'><i class='fa fa-times'></i></button>";

                return $edit . " " . $update;
            })
            ->editColumn('dil_kod', function ($query){
                return strtoupper($query->dil_kod);
            })
            ->rawColumns(["dil_sira","dil_durum", "actions"])
            ->make(true);

        return $data;
    }

    // DIL SIRALAMA GUNCELLEME KISMINI GERCEKLESTIRELIM
    public function rankSetter(Request $request){
        parse_str($request->post('data'),$sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v){
            LanguageModel::where("dil_id",$v)->update(array(
                "dil_sira" => $k
            ));
        }
    }
}