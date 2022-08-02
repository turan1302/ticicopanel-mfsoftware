<?php

namespace App\Http\Controllers\api\back\sliderlar;

use App\Http\Controllers\Controller;
use App\Models\SliderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index(){
        $query = SliderModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sld_sira", function ($query) {
                $query->orderBy("sld_sira", "asc");
            })
            ->addColumn("sld_resim", function ($query) {
                if ($query->d_resim != "" && File::exists("storage/" . $query->sld_resim)) {
                    $image = "<img src='" . asset('storage/' . $query->sld_resim) . "' width='50' height='50'>";
                } else {
                    $image = "<img src='" . asset('storage/resim-yok.webp') . "' width='50' height='50'>";
                }

                return $image;
            })
            ->addColumn("sld_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("sld_durum", function ($query) {
                $checkedStatus = ($query->sld_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->sld_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.duyurular.show', $query->d_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.duyurular.edit', $query->d_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->d_id'><i class='fa fa-times'></i> Sil</button>";

                return $delete;
            })
            ->editColumn('sld_dil_kod', function ($query) {
                return strtoupper($query->sld_dil_kod);
            })
            ->rawColumns(["sld_sira", "sld_resim", "sld_durum", "actions"])
            ->make(true);

        return $data;
    }

    // SIRALAMA KISMI AYARLANMASINI GERCEKLESTIRELIM
    public function rankSetter(Request $request){
        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            SliderModel::where("sld_id", $v)->update(array(
                "sld_sira" => $k
            ));
        }
    }

    // SLIDER AKRTIF PASIF KISMI AYARLAMA
    public function isActiveSetter(Request $request,SliderModel $item){
        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "sld_durum" => $data
        ));
    }


    // SLIDER SILME ISLEMI
    public function delete(SliderModel $item){
        if ($item->sld_resim !="" && File::exists("storage/".$item->sld_resim)){
            File::delete("storage/".$item->sld_resim);
        }

        $sonuc = $item->delete();

        if ($sonuc) {
            $alert = [
                "type" => "success",
                "title" => "Başarılı",
                "text" => "İşlem Başarılı",
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "İşlem Başarısız",
            ];
        }
        return response()->json($alert);

    }

}
