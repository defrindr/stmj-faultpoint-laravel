<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariEfektif extends Model
{
    protected $table = "hari_efektif";
    protected $fillable = [
        // "hari",
        "status",
        "update_at",
    ];
    protected $hidden = [
        "created_at",
        "update_at",
    ];

    function getStatus(){
        return ($this->status) ? "Ya" : "Tidak" ;
    }

}
