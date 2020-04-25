<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = "kelas";
    protected $fillable = [
        "kelas_x",
        "kelas_xi",
        "kelas_xii",
        "grade",
        "jurusan_id",
        "user_id",
    ];

    function siswa() {
        return $this->hasMany('App\Models\Siswa');
    }
    function jurusan() {
        return $this->belongsTo('App\Models\Jurusan');
    }
}
