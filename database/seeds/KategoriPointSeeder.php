<?php

use Illuminate\Database\Seeder;
use App\Models\KategoriPoint;


class KategoriPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori = [
            [
                "nama" => "PENGHARGAAN",
                "jenis_point" => "positif",
            ],
            [
                "nama" => "KEHADIRAN",
                "jenis_point" => "negatif",
            ],
            [
                "nama" => "KEGIATAN PEMBELAJARAN",
                "jenis_point" => "negatif",
            ],
            [
                "nama" => "PAKAIAN SERAGAM",
                "jenis_point" => "negatif",
            ],
            [
                "nama" => "MAKAN DAN MINUM",
                "jenis_point" => "negatif",
            ],
            [
                "nama" => "TINDAKAN KENAKALAN DAN KRIMINALITAS",
                "jenis_point" => "negatif",
            ],
            [
                "nama" => "PRAKERIN",
                "jenis_point" => "negatif",
            ],
        ];

        foreach($kategori as $row){
            KategoriPoint::create($row);
        }

    }
}
