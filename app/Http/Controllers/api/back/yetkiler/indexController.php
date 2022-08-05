<?php

namespace App\Http\Controllers\api\back\yetkiler;

use App\Http\Controllers\Controller;
use App\Models\YetkiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index(){
        $query = YetkiModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->addColumn("yt_durum", function ($query) {
                $checkedStatus = ($query->yt_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->yt_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.service.show', $query->service_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
                $edit = "<a href='" . route('back.yetkiler.edit', $query->yt_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->yt_id'><i class='fa fa-times'></i> Sil</button>";

                return  $edit." ".$delete;
            })
            ->rawColumns(["yt_durum", "actions"])
            ->make(true);

        return $data;
    }

    // YATKI KISMI AYARLANMASI
    public function store(Request $request){
        $data = $request->except("_token");

        $result = YetkiModel::create($data);

        if ($result) {
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
    public function edit(YetkiModel $item){
        return response()->json($item);
    }

    // GUNCELLEME ISLEMI
    public function update(Request $request,YetkiModel $item){
        $data = $request->except("_token");

        $result = $item->update($data);

        if ($result) {
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

    // SILME KISMI AYARLANMASI
    public function delete(YetkiModel $item){
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

    // AKTIFLIK KISMI AYARLANMASI
    public function isActiveSetter(Request $request, YetkiModel $item)
    {
        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "yt_durum" => $data
        ));
    }
}
