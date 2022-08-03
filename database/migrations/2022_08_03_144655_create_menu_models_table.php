<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menuler', function (Blueprint $table) {
            $table->id('menu_id');
            $table->string('menu_baslik')->nullable();
            $table->string('menu_link')->nullable();
            $table->tinyInteger('menu_durum')->default(1)->nullable();
            $table->tinyInteger('menu_sira')->default(0)->nullable();
            $table->tinyInteger('menu_ust_id')->default(0)->nullable();
            $table->string('menu_dil_kod')->default('tr')->nullable();
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
        Schema::dropIfExists('menuler');
    }
}
