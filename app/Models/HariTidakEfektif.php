<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariTidakEfektif extends Model
{
    protected $table = "hari_tidak_efektif";
    protected $fillable = [
        "tanggal",
        "status",
        "keterangan",
    ];
}
