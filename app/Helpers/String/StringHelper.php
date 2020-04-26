<?php
namespace App\Helpers\String;


class StringHelper {


    static function toRp($val){
        if ($val == 0) return "-";
        return "Rp ". strrev(
            join(
                ".",
                str_split(
                    strrev(
                        (string) $val
                    ),
                    3
                )
            )
        ) . ",-";
    }


    static function date($val){
        $val = date('d-m-Y',strtotime($val));
        $date = explode('-', $val);

        $bulan = array (1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );

        return $date[0]." ".$bulan[ (int) $date[1] ]. " ".$date[2];

    }


    static function datetime($val){
        $date = self::date($val);
        $times = date('H:i A', strtotime($val));

        return $times . " " . $date;
    }
}