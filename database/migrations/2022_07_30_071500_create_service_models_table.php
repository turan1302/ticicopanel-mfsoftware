<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id('service_id');
            $table->string('service_ikon')->nullable()->comment('font awesome kodları kullandırtabiliriz');
            $table->string('service_baslik')->nullable();
            $table->string('service_slug')->nullable();
            $table->text('service_aciklama')->nullable();
            $table->string('service_title')->nullable();
            $table->string('service_description')->nullable();
            $table->string('service_keyword')->nullable();
            $table->string('service_etiketler')->nullable();
            $table->string('service_sef_etiketler')->nullable();
            $table->tinyInteger('service_durum')->default(1)->nullable();
            $table->tinyInteger('service_sira')->default(0)->nullable();
            $table->string('service_dil_kod')->nullable()->default('tr')->comment('hiçbir dil seçeneği yok ise tr eklenecek');
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
        Schema::dropIfExists('services');
    }
}
