<?php

use Illuminate\Database\Seeder;
use App\Models\HariEfektif;
class HariEfektifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hari = [
            [
                "hari" => "Minggu",
                "status" => false,
            ],
            [
                "hari" => "Senin",
                "status" => true
            ],
            [
                "hari" => "Selasa",
                "status" => true
            ],
            [
                "hari" => "Rabu",
                "status" => true
            ],
            [
                "hari" => "Kamis",
                "status" => true
            ],
            [
                "hari" => "Jum'at",
                "status" => true
            ],
            [
                "hari" => "Sabtu",
                "status" => false,
            ],
        ];
        
        foreach($hari as $row){
            HariEfektif::create($row);
        }
    }
}
