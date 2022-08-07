<?php

namespace App\Http\Controllers\api\back\duyurular;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\DuyuruModel;
use App\Models\PivotDuyuruKategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public $uploadFolder = "";

    public function __construct()
    {
        $this->uploadFolder = "duyuru";

        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('duyurular', "aktiflik") === false) {
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

        if (myHelper::yetkiKontrol('duyurular', "listeleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

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
                $show = "<a href='" . route('back.duyurular.show', $query->d_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
                $edit = "<a href='" . route('back.duyurular.edit', $query->d_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->d_id'><i class='fa fa-times'></i> Sil</button>";

                return $show." ".$edit . " " . $delete;
            })
            ->editColumn('d_dil_kod', function ($query) {
                return strtoupper($query->d_dil_kod);
            })
            ->rawColumns(["d_sira", "d_resim", "d_durum", "actions"])
            ->make(true);

        return $data;
    }

    // DUYURU KAYDETME KISMI AYARLANMASI
    public function store(Request $request)
    {
        if (myHelper::yetkiKontrol('duyurular', "ekleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $duyuru_kategoriler = $request->d_kategoriler;  // DUYURU KATEGORILERINI ALDIK
        $data = $request->except("_token", "d_kategoriler");

        // AYNI SLUGDAN VAR MI KONTROL EDELIM
        $sorgu = DuyuruModel::where(array(
            "d_slug" => Str::slug($data['d_baslik'])
        ))->first();


        if ($sorgu) {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "text" => "Aynı Duyuru Zaten Mevcut",
            ];

            return response()->json($alert);
        }

        // DOSYA GELDI MI
        $data['d_resim'] = "";
        if ($request->hasFile('d_resim')) {
            $file = $request->file('d_resim');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {
                $file_name = Str::slug($data['d_baslik']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['d_resim'] = $file->storeAs($this->uploadFolder, $file_name);
            } else {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Altında  ve JPEG,JPG ve PNG Dosyası Yükleyiniz",
                ];

                return response()->json($alert);
            }
        }

        $result = DuyuruModel::create($data);

        /** DUYURU KATEGORILERI KISMI AYARLANMASI **/
        DuyuruModel::duyuruCokluKategoriEkle($result->d_id, $duyuru_kategoriler);

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

    // GUNCELLEME SAYFASIN ALINMASINI GERCKELESTIRELIM
    public function edit(DuyuruModel $item)
    {
        if (myHelper::yetkiKontrol('duyurular', "guncelleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $duyuru = DuyuruModel::select("pivot_duyuru_kategori.pdk_dkat_id")->leftJoin("pivot_duyuru_kategori", "pivot_duyuru_kategori.pdk_duyuru_id", "=", "duyurular.d_id")->get();
        return response()->json([$item, $duyuru]);
    }

    // GORUNTULEME SAYFASI
    public function show(DuyuruModel $item)
    {
        if (myHelper::yetkiKontrol('duyurular', "goruntuleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $duyuru = DuyuruModel::select("pivot_duyuru_kategori.pdk_dkat_id")->leftJoin("pivot_duyuru_kategori", "pivot_duyuru_kategori.pdk_duyuru_id", "=", "duyurular.d_id")->get();
        return response()->json([$item, $duyuru]);
    }

    // GUNCELLEME KISMINI AYARLAUYALIM
    public function update(Request $request, DuyuruModel $item)
    {
        if (myHelper::yetkiKontrol('duyurular', "guncelleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $duyuru_kategoriler = $request->d_kategoriler;  // DUYURU KATEGORILERINI ALDIK
        $data = $request->except("_token", "d_kategoriler");

        // AYNI SLUGDAN VAR MI KONTROL EDELIM BI
        if ($data['d_baslik'] != $item->d_baslik) {
            $sorgu = DuyuruModel::where(array(
                "d_slug" => Str::slug($data['d_baslik'])
            ))->first();


            if ($sorgu) {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "Aynı Duyuru Zaten Mevcut",
                ];

                return response()->json($alert);
            }
        }

        // RESIM GELMIS ISE
        $data['d_resim'] = $item->d_resim;
        if ($request->hasFile('d_resim')) {
            $file = $request->file('d_resim');
            $desteklenen_uzantilar = ["jpeg", "jpg", "png"];
            if (in_array($file->getClientOriginalExtension(), $desteklenen_uzantilar)) {

                // MEVCUT RESMI SILDIRME ISLEMI GERCEKLESTRIELIM
                if ($item->d_resim != "" && File::exists("storage/" . $item->d_resim)) {
                    File::delete("storage/" . $item->d_resim);
                }

                $file_name = Str::slug($data['d_baslik']) . "-" . time() . "." . $file->getClientOriginalExtension();
                $data['d_resim'] = $file->storeAs($this->uploadFolder, $file_name);
            } else {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "2 MB Altında  ve JPEG,JPG ve PNG Dosyası Yükleyiniz",
                ];

                return response()->json($alert);
            }
        }

        $result = $item->update($data);

        /** DUYURU KATEGORILERININ SILINMESINI AYARLAYALIM ONCE **/
        PivotDuyuruKategoriModel::where(array(
            "pdk_duyuru_id" => $item->d_id
        ))->delete();

        /** DUYURU KATEGORILERI KISMI AYARLANMASI **/
        DuyuruModel::duyuruCokluKategoriEkle($item->d_id, $duyuru_kategoriler);

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
    public function delete(DuyuruModel $item)
    {

        if (myHelper::yetkiKontrol('duyurular', "silme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        if ($item->d_resim != "" && File::exists("storage/" . $item->d_resim)) {
            File::delete("storage/" . $item->d_resim);
        }

        $sonuc = $item->delete();

        /** DUYURUYU PIVOT TABLODAN SILDIRELIM **/
        PivotDuyuruKategoriModel::where(array(
            "pdk_duyuru_id" => $item->d_id
        ))->delete();

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

    // AKTIF PASIF KISMI AYARLANAMSI
    public function isActiveSetter(Request $request, DuyuruModel $item)
    {
        if (myHelper::yetkiKontrol('duyurular', "guncelleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "d_durum" => $data
        ));
    }

    // SIRALAMA KISMI AYARLANMASI
    public function rankSetter(Request $request)
    {
        if (myHelper::yetkiKontrol('duyurular', "guncelleme") === false) {
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            DuyuruModel::where("d_id", $v)->update(array(
                "d_sira" => $k
            ));
        }
    }
}
