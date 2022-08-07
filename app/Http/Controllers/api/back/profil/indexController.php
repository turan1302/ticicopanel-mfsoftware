<?php

namespace App\Http\Controllers\api\back\profil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        $user = auth()->guard('yonetim')->user();
        return response()->json($user);
    }
}
