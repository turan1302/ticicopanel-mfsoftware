<?php

namespace App\Http\Controllers\api\back\sosyal_medya;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\SosyalMedyaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (myHelper::yetkiKontrol('sosyal_medya',"aktiflik")===false){
                return redirect()->route('back.home.index')->with(array(
                    "type" => "error",
                    "title" => "Hata",
                    "text" => "Yetkiniz Yok"
                ));
            }
            return $next($request);
        });
    }

    public function index(){

        if (myHelper::yetkiKontrol('sosyal_medya',"listeleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $query = SosyalMedyaModel::query();
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sm_sira", function ($query) {
                $query->orderBy("sm_sira", "asc");
            })
            ->addColumn("sm_sira", function ($query) {
                return '<span class="material-icons">reorder</span>';
            })
            ->addColumn("sm_durum", function ($query) {
                $checkedStatus = ($query->sm_durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-id='$query->sm_id' $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
                $show = "<a href='" . route('back.sosyal_medya.show', $query->sm_id) . "' class='btn btn-warning btn-md'><i class='fa fa-edit'></i> Görüntüle</a>";
                $edit = "<a href='" . route('back.sosyal_medya.edit', $query->sm_id) . "' class='btn btn-primary btn-md'><i class='fa fa-edit'></i> Güncelle</a>";
                $delete = "<button type='button' class='btn btn-danger btn-md isDelete' data-id='$query->sm_id'><i class='fa fa-times'></i> Sil</button>";
//
                return  $show." ".$edit." ".$delete;
            })
            ->rawColumns(["sm_sira", "sm_durum", "actions"])
            ->make(true);

        return $data;
    }

    // STORE KISMI AYARLANMASI
    public function store(Request $request){

        if (myHelper::yetkiKontrol('sosyal_medya',"ekleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = $request->except("_token");
        $sonuc = SosyalMedyaModel::create($data);

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

    // SOSYAL MEDYA GUNCELLEME KISMI AYARLANMASINI GERCEKLESTIRELEIM
    public function edit(SosyalMedyaModel $item){

        if (myHelper::yetkiKontrol('sosyal_medya',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // SOSYAL MEDYA GORUNTULEME KISMI AYARLANMASINI GERCEKLESTIRELIM
    public function show(SosyalMedyaModel $item){

        if (myHelper::yetkiKontrol('sosyal_medya',"goruntuleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        return response()->json($item);
    }

    // SOSYAL MEDYA GUNCELLEME KISMI
    public function update(Request $request,SosyalMedyaModel $item){

        if (myHelper::yetkiKontrol('sosyal_medya',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

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

    // DELETE KISMI AYARLANMASI GERCEKLESTIRELIM
    public function delete(SosyalMedyaModel $item){

        if (myHelper::yetkiKontrol('sosyal_medya',"silme")===false){
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

    // AKTIOF PASIF KISMI AYARLANAMSI
    public function isActiveSetter(Request $request,SosyalMedyaModel $item){

        if (myHelper::yetkiKontrol('sosyal_medya',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        $data = ($request->data == "true") ? 1 : 0;
        $item->update(array(
            "sm_durum" => $data
        ));
    }

    // SIRALAMA ISLEMI GERCEKLESTIRELIM
    public function rankSetter(Request $request){

        if (myHelper::yetkiKontrol('sosyal_medya',"guncelleme")===false){
            return redirect()->route('back.home.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "text" => "Yetkiniz Yok"
            ));
        }

        parse_str($request->post('data'), $sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v) {
            SosyalMedyaModel::where("sm_id", $v)->update(array(
                "sm_sira" => $k
            ));
        }
    }
}
