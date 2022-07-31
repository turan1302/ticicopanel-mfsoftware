<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DuyuruModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = "duyuru";
    protected $primaryKey = "d_id";

    // SEO URL MUTATOR
    public function setDBaslikAttribute($value){
        $this->attributes['d_baslik'] = $value;
        $this->attributes['d_slug'] = Str::slug($value);
    }

    // SEF ETİKET MUTATOR
    public function setDEtiketlerAttribute($value){
        $this->attributes['d_etiketler'] = $value;  // ETİKET DATASINI ALDIK

        $etiket_explode = explode(",", $value);
        $sef_etiket_data = "";
        foreach ($etiket_explode as $etiket) {
            $sef_etiket_data .= Str::slug($etiket) . ",";
        }
        $sef_etiket_data = rtrim($sef_etiket_data, ",");

        $this->attributes['d_sef_etiketler'] = $sef_etiket_data; // SEF ETİKETLERİNİ ALDIK
    }
}
