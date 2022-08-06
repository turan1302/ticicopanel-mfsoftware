<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAyarModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ayarlar', function (Blueprint $table) {
            $table->id('ayar_id');
            $table->string('site_url')->nullable();
            $table->string('site_baslik')->nullable();
            $table->string('site_desc')->nullable();
            $table->string('site_keyw')->nullable();
            $table->string('site_slogan')->nullable();
            $table->string('site_tel')->nullable()->comment('site tel');
            $table->text('site_adres')->nullable()->comment('site adresi');
            $table->string('site_harita')->nullable();
            $table->tinyInteger('site_harita_durum')->default(1)->comment("1 ise aktif 0 ise pasif")->nullable();
            $table->string('site_mail')->nullable();
            $table->tinyInteger('site_durum')->default(1)->comment("1 ise aktif 0 ise pasif")->nullable();
            $table->string('site_icon')->nullable();
            $table->string('site_favicon')->nullable();
            $table->string('google_dogrulama_kodu')->nullable();
            $table->string('yandex_dogrulama_kodu')->nullable();
            $table->string("bing_dogrulama_kodu")->nullable();
            $table->mediumText('analiytcs_kodu')->nullable();
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
        Schema::dropIfExists('ayarlar');
    }
}
