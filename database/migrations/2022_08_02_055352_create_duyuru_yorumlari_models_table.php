<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuyuruYorumlariModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duyuru_yorumlar', function (Blueprint $table) {
            $table->id('dy_id');
            $table->string('dy_adsoyad')->nullable();
            $table->string('dy_email')->nullable();
            $table->string('dy_website')->nullable();
            $table->text('dy_yorum')->nullable();
            $table->string('dy_duyuru_id')->nullable();
            $table->tinyInteger('dy_okunma')->default(0)->nullable();
            $table->tinyInteger('dy_durum')->default(0)->nullable()->comment('sitede gösterme işlemi');
            $table->tinyInteger('dy_yorum_ust')->default(0)->nullable()->comment('ziyaretçi yorum yapınca 0 olacak hep');
            $table->string('dy_ip')->nullable();
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
        Schema::dropIfExists('duyuru_yorumlar');
    }
}
