<?php

namespace App\Http\Controllers\api\back\menuler;

use App\Http\Controllers\Controller;
use App\Models\EkipModel;
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
                $show = "<a href='" . route('back.menuler.show', $query->menu_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
                $edit = "<a href='" . route('back.menuler.edit', $query->menu_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->menu_id'><i class='fa fa-times'></i> Sil</button>";

                return $show." ".$edit." ".$delete;
            })
            ->editColumn('menu_dil_kod', function ($query) {
                return strtoupper($query->menu_dil_kod);
            })
            ->rawColumns(["menu_sira", "menu_resim", "menu_durum", "actions"])
            ->make(true);

        return $data;
    }

    // EKLEME KISMI
    public function store(Request $request){
        $data = $request->except("_token");
        $sonuc = MenuModel::create($data);

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

    // GUNCELLEME KISMI
    public function edit(MenuModel $item){
        return response()->json($item);
    }

    // GORUNTULEME KISMI
    public function show(MenuModel $item){
        return response()->json($item);
    }

    // GUNCELLEME ISLEMI
    public function update(Request $request,MenuModel $item){
        $data = $request->except("_token");

        $sonuc = $item->update($data);

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

    // SILME KISMI
    public function delete(MenuModel $item){
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

    // SIRALAMA KISMI AYARLANAMSI
    public function rankSetter(Request $request)
    {
        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            MenuModel::where("menu_id", $v)->update(array(
                "menu_sira" => $k
            ));
        }
    }

    // AKTIF ĞPASFO KISMI AYARLANSIM
    public function isActiveSetter(Request $request, MenuModel $item)
    {
        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "menu_durum" => $data
        ));
    }
}
