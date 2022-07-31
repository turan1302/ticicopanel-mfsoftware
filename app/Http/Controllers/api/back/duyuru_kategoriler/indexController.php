<?php

namespace App\Http\Controllers\api\back\duyuru_kategoriler;

use App\Http\Controllers\Controller;
use App\Models\DuyuruKategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
        $query = DuyuruKategoriModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("dkat_sira", function ($query) {
                $query->orderBy("dkat_sira", "asc");
            })
            ->addColumn("dkat_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("dkat_durum", function ($query) {
                $checkedStatus = ($query->dkat_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->dkat_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("dkat_varsayilan_kategori", function ($query) {
                $checkedStatus = ($query->dkat_varsayilan_kategori == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isDefault' data-id='$query->dkat_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
//                $show = "<a href='" . route('back.service.show', $query->service_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
//                $edit = "<a href='" . route('back.service.edit', $query->service_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->dkat_id'><i class='fa fa-times'></i> Sil</button>";
//
                return $delete;
            })
            ->editColumn('dkat_dil_kod', function ($query) {
                return strtoupper($query->dkat_dil_kod);
            })
            ->rawColumns(["dkat_sira", "dkat_durum", "dkat_varsayilan_kategori", "actions"])
            ->make(true);

        return $data;
    }

    // KAYIT ETME KISMI
    public function store(Request $request)
    {
        $data = $request->except("_token");

        // SLUG KONTROL YAPALIM
        $kontrol = DuyuruKategoriModel::where(array(
            "dkat_slug" => Str::slug($data['dkat_ad'])
        ))->first();

        if ($kontrol) {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "Aynı Duyuru Kategorisi Zaten Mevcut",
            ];

            return \response()->json($alert);
        }

        $sonuc = DuyuruKategoriModel::create($data);
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

    // AKTIF PASIF KISMI AYARLANMASI
    public function isActiveSetter(Request $request, DuyuruKategoriModel $item)
    {
        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "dkat_durum" => $data
        ));
    }

    // VARSAYILAN KISMI AYARLANMASI
    public function isDefaultSetter(Request $request, DuyuruKategoriModel $item)
    {
        $data = ($request->data == "true") ? 1 : 0;

        DuyuruKategoriModel::where(array())->update(array(
            "dkat_varsayilan_kategori" => 0
        ));

        $item->update(array(
            "dkat_varsayilan_kategori" => 1
        ));
    }

    // SILME KISMI AYARLANAMSI
    public function delete(DuyuruKategoriModel $item)
    {
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

    // SIRALAMA AYARLAMASINI GERCEKLESTIRELIM
    public function rankSetter(Request $request)
    {
        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            DuyuruKategoriModel::where("dkat_id", $v)->update(array(
                "dkat_sira" => $k
            ));
        }
    }
}
