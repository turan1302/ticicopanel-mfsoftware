<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusteriYorumModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musteri_yorumlari', function (Blueprint $table) {
            $table->id('my_id');
            $table->string('my_resim')->nullable();
            $table->string('my_adsoyad')->nullable();
            $table->string('my_unvan')->nullable();
            $table->text('my_aciklama')->nullable();
            $table->tinyInteger('my_durum')->default(1)->nullable();
            $table->tinyInteger('my_sira')->default(0)->nullable();
            $table->string('my_dil_kod')->default('tr')->nullable();
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
        Schema::dropIfExists('musteri_yorumlari');
    }
}
