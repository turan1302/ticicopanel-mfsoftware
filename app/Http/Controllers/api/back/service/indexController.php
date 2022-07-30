<?php

namespace App\Http\Controllers\api\back\service;

use App\Http\Controllers\Controller;
use App\Models\ServiceModel;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    // SERVISLERI CAGIRALIM
    public function index()
    {
        $query = ServiceModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("service_sira", function ($query) {
                $query->orderBy("service_sira", "asc");
            })
            ->addColumn("service_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("service_durum", function ($query) {
                $checkedStatus = ($query->service_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->service_durum' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->service_id'><i class='fa fa-times'></i> Sil</button>";
//
                return $delete;
            })
            ->editColumn('service_dil_kod', function ($query) {
                return strtoupper($query->service_dil_kod);
            })
            ->rawColumns(["service_sira", "service_durum", "actions"])
            ->make(true);

        return $data;
    }

    // SERVIS EKLEME ISLEMI
    public function store(Request $request)
    {
        $data = $request->except("_token");

        // SLUG KONTROLU YAPALIM
        $kontrol = ServiceModel::where(array(
            "service_slug" => Str::slug($data['service_baslik'])
        ))->first();

        // EĞER VARSA
        if ($kontrol) {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "Aynı Servis Zaten Mevcut",
            ];

            return \response()->json($alert);
        }

        $sonuc = ServiceModel::create($data);
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

        return \response()->json($alert);

    }

    // SERVIS SILME KISMINI AYARLAYALIM
    public function delete(ServiceModel $item){
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

    // SERVIS GUNCELLEME KSIMININ AYARLANMASINI GERCEKLESTIRELIM
    public function isActiveSetter(Request $request, ServiceModel $item)
    {
        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "service_durum" => $data
        ));
    }

    // SERVIS SIRALAMA GUNCELLEME
    public function rankSetter(Request $request)
    {
        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            ServiceModel::where("service_id", $v)->update(array(
                "service_sira" => $k
            ));
        }
    }
}
