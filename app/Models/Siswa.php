<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    public $incrementing = false;
    protected $table = "siswa";
    protected $primaryKey = "nip";
    protected $fillable = [
        "nip",
        "kelas_id",
        "nama",
        "alamat_rumah",
        "alamat_domisili",
        "tempat_lahir",
        "tanggal_lahir",
        "no_telp",
        "nama_wali",
        "no_telp_wali",
        "point_pelanggaran",
        "point_penghargaan",
    ];

    function kasus() {
        return $this->hasMany('App\Models\Kasus');
    }
    function absensi() {
        return $this->hasMany('App\Models\Absensi');
    }
    function kelas() {
        return $this->belongsTo(Kelas::class);
    }
}
