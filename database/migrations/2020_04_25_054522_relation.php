<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Relation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->foreignId("role_id")->constrained();
            $table->foreignId("user_id")->constrained();
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->foreignId("jurusan_id")->constrained("jurusan");
            $table->foreignId("user_id")->constrained();
        });
        Schema::table('siswa', function (Blueprint $table) {
            $table->foreignId("kelas_id")->constrained("kelas")->onDelete('cascade');
        });
        Schema::table('point', function (Blueprint $table) {
            $table->foreignId("kategori_point_id")->constrained("kategori_point");
        });
        Schema::table('kasus', function (Blueprint $table) {
            $table->unsignedBigInteger("siswa_nip");
            $table->foreign("siswa_nip")->references("nip")->on("siswa")->onDelete('cascade');

            $table->foreignId("point_id")->constrained("point");
            $table->foreignId("user_id")->constrained("users");
        });
        Schema::table('absensi', function (Blueprint $table) {
            $table->unsignedBigInteger("siswa_nip");
            $table->foreign("siswa_nip")->references("nip")->on("siswa")->onDelete('cascade');

            $table->foreignId("user_id")->constrained("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('siswa', function (Blueprint $table) {
            //
        });
    }
}
