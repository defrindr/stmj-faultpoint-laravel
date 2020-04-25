<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariEfektif extends Model
{
    protected $table = "hari_efektif";
    protected $fillable = [
        "hari",
        "status",
    ];
}
