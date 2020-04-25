<?php

use Illuminate\Database\Seeder;
use App\Models\Point;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $point = [
            [
                "kategori_point_id" => 2,
                "peraturan" => "Datang terlambat 1-15 menit",
                "interval_waktu" => 1,
                "point" => 3,
                "sanksi" => "Membersihkan lingkungan sekolah",
            ],
            [
                "kategori_point_id" => 2,
                "peraturan" => "Datang terlambat 16-30 menit",
                "interval_waktu" => 1,
                "point" => 4,
                "sanksi" => "Membersihkan lingkungan sekolah",
            ],
            [
                "kategori_point_id" => 2,
                "peraturan" => "Tidak masuk sekolah tanpa izin per hari",
                "interval_waktu" => 1,
                "point" => 10,
                "sanksi" => "Peringatan Lisan",
            ],
            [
                "kategori_point_id" => 2,
                "peraturan" => "Tidak masuk sekolah tanpa izin (>=3 hari) per hari",
                "interval_waktu" => 3,
                "point" => 10,
                "sanksi" => "Peringatan Lisan",
            ],
            [
                "kategori_point_id" => 1,
                "peraturan" => "Membawa nama baik sekolah ke tingkat Nasional",
                "interval_waktu" => 1,
                "point" => 50,
                "sanksi" => "-",
            ],
            [
                "kategori_point_id" => 1,
                "peraturan" => "Membawa nama baik sekolah ke tingkat Provinsi",
                "interval_waktu" => 1,
                "point" => 40,
                "sanksi" => "-",
            ],
            [
                "kategori_point_id" => 1,
                "peraturan" => "Membawa nama baik sekolah ke tingkat Kota/Kabupaten",
                "interval_waktu" => 1,
                "point" => 25,
                "sanksi" => "-",
            ],
            [
                "kategori_point_id" => 1,
                "peraturan" => "Membawa nama baik sekolah ke tingkat Kecamatan",
                "interval_waktu" => 1,
                "point" => 15,
                "sanksi" => "-",
            ],
        ];
        
        foreach($point as $row){
            Point::create($row);
        }

    }
}
