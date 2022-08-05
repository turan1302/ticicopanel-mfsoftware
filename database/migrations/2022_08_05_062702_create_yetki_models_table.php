<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYetkiModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yetkiler', function (Blueprint $table) {
            $table->id('yt_id');
            $table->string('yt_baslik')->nullable();
            $table->tinyInteger('yt_durum')->default(1)->nullable();
            $table->text('yt_yetkiler')->nullable();
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
        Schema::dropIfExists('yetkiler');
    }
}
