<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSosyalMedyaModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sosyal_medya', function (Blueprint $table) {
            $table->id('sm_id');
            $table->string('sm_ikon')->nullable();
            $table->string('sm_name')->nullable();
            $table->string('sm_link')->nullable();
            $table->tinyInteger('sm_durum')->default(1)->nullable();
            $table->tinyInteger('sm_sira')->default(0)->nullable();
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
        Schema::dropIfExists('sosyal_medya');
    }
}
