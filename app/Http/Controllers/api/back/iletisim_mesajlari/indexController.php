<?php

namespace App\Http\Controllers\api\back\iletisim_mesajlari;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Mail\MesajCevapMail;
use App\Models\IletisimMesajModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('iletisim_mesajlari',"aktiflik")===false){
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
        if (myHelper::yetkiKontrol('iletisim_mesajlari',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $query = IletisimMesajModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("im_id", function ($query) {
                $query->orderBy("im_id", "desc");
            })
            ->addColumn("im_okundu_bilgisi", function ($query) {
                $color = ($query->im_okundu_bilgisi == 1) ? 'green' : 'red';
                return "<span class='material-icons' style='color: " . $color . ";'>visibility</span>";
            })
            ->addColumn("actions", function ($query) {
                $show = "<a href='" . route('back.iletisim_mesajlari.show', $query->im_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->im_id'><i class='fa fa-times'></i> Sil</button>";
//
                return $show . " " . $delete;
            })
            ->rawColumns(["im_okundu_bilgisi", "actions"])
            ->make(true);

        return $data;
    }

    // GORUNTULEME KISMI
    public function show(IletisimMesajModel $item)
    {
        if (myHelper::yetkiKontrol('iletisim_mesajlari',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // MESAJ CEVAP KISMI AYARLAMASI
    public function reply(Request $request, IletisimMesajModel $item)
    {
        if (myHelper::yetkiKontrol('iletisim_mesajlari',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");
        Mail::to($item->im_email)->send(new MesajCevapMail($item,$data['im_cevap']));

        $alert = [
            "type" => "success",
            "title" => "Başarılı",
            "text" => "İşlem Başarılı",
        ];

        return response()->json($alert);

    }

    // SILME KISMI AYARLANMASI
    public function delete(IletisimMesajModel $item)
    {
        if (myHelper::yetkiKontrol('iletisim_mesajlari',"silme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
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
