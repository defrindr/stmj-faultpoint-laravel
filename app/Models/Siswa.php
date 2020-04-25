<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = "siswa";
    protected $primaryKey = "nip";
    protected $fillable = [
        "nip",
        "kelas_id",
        "nama",
        "point_pelanggaran",
        "point_penghargaan",
    ];

    function kasus() {
        return $this->hasMany('App\Models\Kasus');
    }
    function absensi() {
        return $this->hasMany('App\Models\Absensi');
    }
}
