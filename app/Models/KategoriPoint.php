<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPoint extends Model
{
    protected $table = "kategori_point";
    protected $fillable = [
        "nama",
        "jenis_point",
    ];

    function point() {
        return $this->hasMany('App\Models\Point');
    }
}
