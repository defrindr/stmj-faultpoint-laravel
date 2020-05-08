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
        "tahun_ajaran",
    ];

    function getKelas(){
        if($this->kelas_x) return "X";
        if($this->kelas_xi) return "XI";
        if($this->kelas_xii) return "XII";
    }

    function getPrefix(){
        $kelas = $this->getKelas();
        $jurusan = $this->jurusan->nama;
        $grade = $this->grade;
        $prefix = strtoupper("$kelas $jurusan $grade");
        
        return $prefix;
    }

    function getTotalPoint($column,$id){
        $pointKelas = $this->join('siswa','kelas_id','kelas.id')
            ->groupBy('kelas_id')
            ->having('kelas_id',$id)
            ->sum( $column );
        
        return $pointKelas. " Point";
    }

    function siswa() {
        return $this->hasMany('App\Models\Siswa');
    }
    function jurusan() {
        return $this->belongsTo('App\Models\Jurusan');
    }
    function user() {
        return $this->belongsTo('App\Models\User');
    }
}
