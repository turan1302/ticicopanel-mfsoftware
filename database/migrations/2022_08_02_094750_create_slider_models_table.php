<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliderlar', function (Blueprint $table) {
            $table->id('sld_id');
            $table->string('sld_resim')->nullable();
            $table->string('sld_ustbaslik')->nullable();
            $table->string('sld_ortabaslik')->nullable();
            $table->string('sld_altbaslik')->nullable();
            $table->string('sld_butonbaslik')->nullable();
            $table->string('sld_butonlink')->nullable();
            $table->tinyInteger('sld_durum')->default(1)->nullable();
            $table->tinyInteger('sld_sira')->default(0)->nullable();
            $table->string('sld_dil_kod')->default('tr')->nullable();
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
        Schema::dropIfExists('sliderlar');
    }
}
