<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIletisimMesajModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iletisim_mesajlari', function (Blueprint $table) {
            $table->id('im_id');
            $table->string('im_adsoyad')->nullable();
            $table->string('im_email')->nullable();
            $table->string('im_tel')->nullable();
            $table->string('im_konu')->nullable();
            $table->text('im_mesaj')->nullable();
            $table->tinyInteger('im_okundu_bilgisi')->default(0)->nullable()->comment("0 ise okunmadı, 1 ise okundu");
            $table->string('im_ip_adres')->nullable();
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
        Schema::dropIfExists('iletisim_mesajlari');
    }
}
