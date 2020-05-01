<?php

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = [
            [
                "kelas_x" => false,
                "kelas_xi" => false,
                "kelas_xii" => true,
                "grade" => "A",
                "tahun_ajaran" => "2019/2020",
                "jurusan_id" => 1,
                "user_id" => 2,
            ],
            [
                "kelas_x" => false,
                "kelas_xi" => false,
                "kelas_xii" => true,
                "grade" => "B",
                "tahun_ajaran" => "2019/2020",
                "jurusan_id" => 1,
                "user_id" => 3,
            ],
        ];

        foreach($kelas as $row) {
            Kelas::create($row);
        }
    }
}
