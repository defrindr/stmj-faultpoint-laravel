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

    public function getStatus(){
        if($this->status == 1)
            return "Hari Libur Optional";
        else
            return "Hari Libur Nasional";
    }
}
