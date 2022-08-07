<?php

namespace App\Http\Controllers\back\yetkiler;

use App\Helpers\myHelper;
use App\Http\Controllers\Controller;
use App\Models\YetkiModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->isSuperAdmin==0){
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
        return view('back.yetkiler.index');
    }

    // EKLEME KSMI
    public function create(){
        return view('back.yetkiler.create');
    }

    // GUNCLELEME KISMI
    public function edit(YetkiModel $item){
        return view('back.yetkiler.edit',compact('item'));
    }

    // VERILEN YETKILER KISMI AYRLANAMSI
    public function verilen_yetkiler(YetkiModel $item){
        $yetkiler = json_encode(myHelper::get_yetkiler());
        return view('back.yetkiler.verilen_yetkiler',compact('item','yetkiler'));
    }
}
