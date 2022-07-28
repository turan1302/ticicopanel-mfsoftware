<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language', function (Blueprint $table) {
            $table->id('dil_id');
            $table->string('dil_ad')->nullable();
            $table->string('dil_kod')->nullable();
            $table->string('dil_ikon')->nullable();
            $table->tinyInteger('dil_durum')->default(1)->nullable();
            $table->tinyInteger('dil_varsayilan')->default(0)->nullable();
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
        Schema::dropIfExists('language');
    }
}
