<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = "absensi";
    protected $fillable = [
        "siswa_nip",
        "tanggal",
        "status",
        "keterangan",
        "user_id",
    ];

    function siswa(){
        return $this->belongsTo("App\Models\Siswa");
    }
}
