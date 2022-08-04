<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SayfaModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = "sayfalar";
    protected $primaryKey = "sayfa_id";

    // SEO URL MUTATOR
    public function setSayfaBaslikAttribute($value){
        $this->attributes['sayfa_baslik'] = $value;
        $this->attributes['sayfa_slug'] = Str::slug($value);
    }

    // SEF ETİKET MUTATOR
    public function setSayfaEtiketlerAttribute($value){
        $this->attributes['sayfa_etiketler'] = $value;  // ETİKET DATASINI ALDIK

        $etiket_explode = explode(",", $value);
        $sef_etiket_data = "";
        foreach ($etiket_explode as $etiket) {
            $sef_etiket_data .= Str::slug($etiket) . ",";
        }
        $sef_etiket_data = rtrim($sef_etiket_data, ",");

        $this->attributes['sayfa_sef_etiketler'] = $sef_etiket_data; // SEF ETİKETLERİNİ ALDIK
    }
}
