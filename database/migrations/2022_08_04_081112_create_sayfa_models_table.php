<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSayfaModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sayfalar', function (Blueprint $table) {
            $table->id('sayfa_id');
            $table->string('sayfa_resim')->nullable();
            $table->string('sayfa_baslik')->nullable();
            $table->string('sayfa_slug')->nullable();
            $table->text('sayfa_kisa_aciklama')->nullable();
            $table->text('sayfa_aciklama')->nullable();
            $table->string('sayfa_title')->nullable();
            $table->string('sayfa_description')->nullable();
            $table->string('sayfa_keyword')->nullable();
            $table->string('sayfa_etiketler')->nullable();
            $table->string('sayfa_sef_etiketler')->nullable();
            $table->tinyInteger('sayfa_durum')->default(1)->nullable();
            $table->string('sayfa_dil_kod')->default('tr')->nullable();
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
        Schema::dropIfExists('sayfalar');
    }
}
