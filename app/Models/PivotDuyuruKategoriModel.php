<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PivotDuyuruKategoriModel extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "pivot_duyuru_kategori";
    protected $primaryKey = "pdk_id";
}
