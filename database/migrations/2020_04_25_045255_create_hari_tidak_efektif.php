<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHariTidakEfektif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hari_tidak_efektif', function (Blueprint $table) {
            $table->id();
            $table->dateTime("tanggal");
            $table->integer("status"); // 0 = hari libur nasional, 1=lainnya
            $table->string("keterangan");
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
        Schema::dropIfExists('hari_tidak_efektif');
    }
}
