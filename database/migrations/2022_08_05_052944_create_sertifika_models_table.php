<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikaModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikalar', function (Blueprint $table) {
            $table->id('sr_id');
            $table->string('sr_baslik')->nullable();
            $table->string('sr_aciklama')->nullable();
            $table->date("sr_yil")->nullable();
            $table->string('sr_derece')->nullable();
            $table->tinyInteger('sr_durum')->default(1)->nullable();
            $table->tinyInteger('sr_sira')->default(0)->nullable();
            $table->string('sr_dil_kod')->default('tr')->nullable();
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
        Schema::dropIfExists('sertifikalar');
    }
}
