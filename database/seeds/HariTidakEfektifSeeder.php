<?php

use Illuminate\Database\Seeder;
use App\Models\HariTidakEfektif;
class HariTidakEfektifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // 0 = hari libur nasional, 1=lainnya
        $hari = [
            [
                "tanggal" => "2020-12-25",
                "status" => 0,
                "keterangan" => "Cuti bersama hari Natal",
            ],
            [
                "tanggal" => "2020-11-28",
                "status" => 1,
                "keterangan" => "Study Tour kelas XII 2020",
            ],
        ];

        foreach($hari as $row){
            HariTidakEfektif::create($row);
        }
    }
}
