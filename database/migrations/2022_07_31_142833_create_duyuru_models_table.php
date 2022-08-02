<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuyuruModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duyurular', function (Blueprint $table) {
            $table->id('d_id');
            $table->string('d_resim')->nullable();
            $table->string('d_baslik')->nullable();
            $table->string('d_slug')->nullable();
            $table->text('d_aciklama')->nullable();
            $table->string('d_title')->nullable();
            $table->string('d_description')->nullable();
            $table->string('d_keyword')->nullable();
            $table->integer('d_varsayilan_kategori')->default(0)->nullable()->comment('varsayılan kategori id numarası gelecek dinamik url icin');
            $table->tinyInteger('d_durum')->default(1)->nullable();
            $table->tinyInteger('d_sira')->default(0)->nullable();
            $table->string('d_etiketler')->nullable();
            $table->string('d_sef_etiketler')->nullable();
            $table->integer('d_goruntulenme')->default(0)->nullable();
            $table->string('d_dil_kod')->default('tr')->nullable();
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
        Schema::dropIfExists('duyurular');
    }
}
