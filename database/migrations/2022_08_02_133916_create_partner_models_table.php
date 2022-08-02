<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partnerlar', function (Blueprint $table) {
            $table->id('part_id');
            $table->string('part_resim')->nullable();
            $table->string('part_baslik')->nullable();
            $table->string('part_slug')->nullable();
            $table->text('part_aciklama')->nullable();
            $table->string('part_link')->nullable();
            $table->string('part_title')->nullable();
            $table->string('part_description')->nullable();
            $table->string('part_keyword')->nullable();
            $table->string('part_etiketler')->nullable();
            $table->string('part_sef_etiketler')->nullable();
            $table->tinyInteger('part_durum')->default(1)->nullable();
            $table->tinyInteger('part_sira')->default(0)->nullable();
            $table->string('part_dil_kod')->nullable();
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
        Schema::dropIfExists('partnerlar');
    }
}
