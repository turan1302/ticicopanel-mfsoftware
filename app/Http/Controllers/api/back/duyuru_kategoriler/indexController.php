<?php

namespace App\Http\Controllers\api\back\duyuru_kategoriler;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\DuyuruKategoriModel;
use App\Models\PivotDuyuruKategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('duyuru_kategorileri', "aktiflik") === false) {
                return redirect()->route('back.home.index')->with(array(
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "Yetkiniz Yok"
                ));
            }
            return $next($request);
        });
    }

    public function index()
    {

        if (myHelper::yetkiKontrol('duyuru_kategorileri', "listeleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

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
                $show = "<a href='" . route('back.duyuru_kategoriler.show', $query->dkat_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> G??r??nt??le</a>";
                $edit = "<a href='" . route('back.duyuru_kategoriler.edit', $query->dkat_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> G??ncelle</a>";

                $delete = "";
                if ($query->dkat_silinebilir_kategori != "" && $query->dkat_silinebilir_kategori==1){
                    $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->dkat_id'><i class='fa fa-times'></i> Sil</button>";
                }
//
                return $show." ".$edit." ".$delete;
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

        if (myHelper::yetkiKontrol('duyuru_kategorileri', "ekleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");

        // SLUG KONTROL YAPALIM
        $kontrol = DuyuruKategoriModel::where(array(
            "dkat_slug" => Str::slug($data['dkat_ad'])
        ))->first();

        if ($kontrol) {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "Ayn?? Duyuru Kategorisi Zaten Mevcut",
            ];

            return \response()->json($alert);
        }

        $sonuc = DuyuruKategoriModel::create($data);
        if ($sonuc) {
            $alert = [
                "type" => "success",
                "title" => "Ba??ar??l??",
                "text" => "????lem Ba??ar??l??",
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "????lem Ba??ar??s??z",
            ];
        }

        return \response()->json($alert);

    }

    // AKTIF PASIF KISMI AYARLANMASI
    public function isActiveSetter(Request $request, DuyuruKategoriModel $item)
    {
        if (myHelper::yetkiKontrol('duyuru_kategorileri', "guncelleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "dkat_durum" => $data
        ));
    }

    // VARSAYILAN KISMI AYARLANMASI
    public function isDefaultSetter(Request $request, DuyuruKategoriModel $item)
    {
        if (myHelper::yetkiKontrol('duyuru_kategorileri', "guncelleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = ($request->data == "true") ? 1 : 0;

        DuyuruKategoriModel::where(array())->update(array(
            "dkat_varsayilan_kategori" => 0
        ));

        $item->update(array(
            "dkat_varsayilan_kategori" => 1
        ));
    }

    // GUNCELLEME SAYFASI ICIN VERILERIN CEKILESI
    public function edit(DuyuruKategoriModel $item){

        if (myHelper::yetkiKontrol('duyuru_kategorileri', "guncelleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // GORUNTULEME SAYFASI ICIN VERILERIN CEKILMESI
    public function show(DuyuruKategoriModel $item){

        if (myHelper::yetkiKontrol('duyuru_kategorileri', "goruntuleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // GUNCELLEME ISLEMI GERCEKLESTIRILMESI
    public function update(Request $request,DuyuruKategoriModel $item){

        if (myHelper::yetkiKontrol('duyuru_kategorileri', "guncelleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");

        // KONTROL YAPALIM
        if ($request->dkat_ad != $item->dkat_ad){
            $kontrol = DuyuruKategoriModel::where(array(
                "dkat_slug" => Str::slug($data['dkat_ad'])
            ))->first();

            if ($kontrol){
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "Ayn?? Duyuru Kategorisi Zaten Mevcut",
                ];

                return \response()->json($alert);
            }
        }

        $sonuc = $item->update($data);

        if ($sonuc) {
            $alert = [
                "type" => "success",
                "title" => "Ba??ar??l??",
                "text" => "????lem Ba??ar??l??",
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "????lem Ba??ar??s??z",
            ];
        }

        return \response()->json($alert);

    }

    // SILME KISMI AYARLANAMSI
    public function delete(DuyuruKategoriModel $item)
    {
        if (myHelper::yetkiKontrol('duyuru_kategorileri', "silme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        // PIVOT KISIMDAN DUYURU VARSAYILAN KATEGORININ CEKILMEISNI GERCEKLESTIREELIM
        $varsayilan_kategori = DuyuruKategoriModel::varsayilanDuyuruKategori();

        PivotDuyuruKategoriModel::where(array(
            "pdk_dkat_id" => $item->dkat_id
        ))->update(array(
            "pdk_dkat_id" => $varsayilan_kategori
        ));

        $sonuc = $item->delete();
        if ($sonuc) {
            $alert = [
                "type" => "success",
                "title" => "Ba??ar??l??",
                "text" => "????lem Ba??ar??l??",
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "????lem Ba??ar??s??z",
            ];
        }
        return response()->json($alert);
    }

    // SIRALAMA AYARLAMASINI GERCEKLESTIRELIM
    public function rankSetter(Request $request)
    {
        if (myHelper::yetkiKontrol('duyuru_kategorileri', "guncelleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            DuyuruKategoriModel::where("dkat_id", $v)->update(array(
                "dkat_sira" => $k
            ));
        }
    }
}
