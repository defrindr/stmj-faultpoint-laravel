<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->unsignedBigInteger("nip")->unique();
            $table->string("nama");
            $table->text("alamat_rumah");
            $table->text("alamat_domisili");
            $table->string("tempat_lahir");
            $table->date("tanggal_lahir");
            $table->text("no_telp");
            $table->text("nama_wali");
            $table->text("no_telp_wali");
            $table->bigInteger("point_pelanggaran");
            $table->bigInteger("point_penghargaan");
            $table->timestamps();

            $table->primary("nip");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}
