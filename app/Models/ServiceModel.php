<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ServiceModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $table = "services";
    protected $primaryKey = "service_id";

    // SEO URL MUTATOR
    public function setServiceBaslikAttribute($value){
        $this->attributes['service_baslik'] = $value;
        $this->attributes['service_slug'] = Str::slug($value);
    }

    // SEF ETİKET MUTATOR
    public function setServiceEtiketlerAttribute($value){
        $this->attributes['service_etiketler'] = $value;  // ETİKET DATASINI ALDIK

        $etiket_explode = explode(",", $value);
        $sef_etiket_data = "";
        foreach ($etiket_explode as $etiket) {
            $sef_etiket_data .= Str::slug($etiket) . ",";
        }
        $sef_etiket_data = rtrim($sef_etiket_data, ",");

        $this->attributes['service_sef_etiketler'] = $sef_etiket_data; // SEF ETİKETLERİNİ ALDIK
    }
}
