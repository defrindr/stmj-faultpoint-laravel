<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kasus extends Model
{
    protected $table = "kasus";
    protected $fillable = [
        "siswa_nip",
        "point_id",
        "tanggal",
        "user_id",
    ];

    function point() {
        return $this->belongsTo('App\Models\Point');
    }
    function siswa() {
        return $this->belongsTo('App\Models\Siswa');
    }
}
