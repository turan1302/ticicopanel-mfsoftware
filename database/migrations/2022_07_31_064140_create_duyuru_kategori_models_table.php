<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuyuruKategoriModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duyuru_kategoriler', function (Blueprint $table) {
            $table->id('dkat_id');
            $table->string('dkat_ad')->nullable();
            $table->string('dkat_slug')->nullable();
            $table->string('dkat_title')->nullable();
            $table->string('dkat_description')->nullable();
            $table->string('dkat_keyword')->nullable();
            $table->tinyInteger('dkat_sira')->default(0)->nullable();
            $table->tinyInteger('dkat_durum')->default(1)->nullable();
            $table->integer('dkat_silinebilir_kategori')->default(1)->nullable()->comment("0 ise silinemez, 1 ise silinebilir kategori");
            $table->tinyInteger('dkat_varsayilan_kategori')->default(0)->nullable()->comment("0 ise varsayılan değil, 1 ise varsayılan kategori");
            $table->string('dkat_dil_kod')->default('tr')->nullable();
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
        Schema::dropIfExists('duyuru_kategoriler');
    }
}
