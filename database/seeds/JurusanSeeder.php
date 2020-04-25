<?php

use Illuminate\Database\Seeder;
use App\Models\Jurusan;


class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jurusan = [
            [
                "nama" => "Rekayasa Perangkat Lunak"
            ],
            [
                "nama" => "Elektronika Industri"
            ],
            [
                "nama" => "Otomasi Industri"
            ],
            [
                "nama" => "Teknik Pemesinan"
            ],
            [
                "nama" => "Teknik dan Bisnis Sepeda Motor"
            ],
            [
                "nama" => "Teknik Pendingin"
            ],
            [
                "nama" => "Bisnis Konstruksi dan Properti"
            ],
            [
                "nama" => "Desain Permodelan dan Informasi Bangunan"
            ],
            [
                "nama" => "Teknik Pengelasan"
            ],
        ];

        foreach($jurusan as $row){
            jurusan::create($row);
        }
    }
}
