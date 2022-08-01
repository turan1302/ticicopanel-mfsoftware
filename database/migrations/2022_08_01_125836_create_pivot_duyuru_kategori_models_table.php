<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotDuyuruKategoriModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivot_duyuru_kategori', function (Blueprint $table) {
            $table->id('pdk_id');
            $table->integer('pdk_duyuru_id')->nullable()->comment('duyuru id numarası');
            $table->integer('pdk_dkat_id')->nullable()->comment('duyuru kategori id numarası');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pivot_duyuru_kategori');
    }
}
