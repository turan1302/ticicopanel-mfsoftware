<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DuyuruKategoriModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = "duyuru_kategoriler";
    protected $primaryKey = "dkat_id";

    // SEO URL MUTATOR
    public function setDkatAdAttribute($value){
        $this->attributes['dkat_ad'] = $value;
        $this->attributes['dkat_slug'] = Str::slug($value);
    }
}
