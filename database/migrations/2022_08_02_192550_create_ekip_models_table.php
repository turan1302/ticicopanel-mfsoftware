<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEkipModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ekip', function (Blueprint $table) {
            $table->id('ekp_id');
            $table->string('ekp_resim')->nullable();
            $table->string('ekp_adsoyad')->nullable();
            $table->string('ekp_unvan')->nullable();
            $table->string('ekp_facebook')->nullable();
            $table->string('ekp_twitter')->nullable();
            $table->string('ekp_instagram')->nullable();
            $table->string('ekp_telefon')->nullable();
            $table->tinyInteger('ekp_durum')->default(1)->nullable();
            $table->tinyInteger('ekp_sira')->default(0)->nullable();
            $table->string('ekp_dil_kod')->default('tr')->nullable();
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
        Schema::dropIfExists('ekip');
    }
}
