<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Siswa;
use Faker\Generator as Faker;

$factory->define(Siswa::class, function (Faker $faker) {
    return [
        "nip" => $faker->numberBetween(111111111,99999999),
        "kelas_id" => $faker->numberBetween(1,2),
        "nama" => $faker->name,
        "alamat_rumah" => $faker->address,
        "alamat_domisili" => $faker->address,
        "tempat_lahir" => $faker->address,
        "tanggal_lahir" => $faker->date,
        "no_telp" => $faker->phoneNumber,
        "nama_wali" => $faker->name,
        "no_telp_wali" => $faker->phoneNumber,
        "point_pelanggaran" => $faker->randomNumber(2),
        "point_penghargaan"=> $faker->randomNumber(2),
    ];
});
