<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Siswa;
use Faker\Generator as Faker;

$factory->define(Siswa::class, function (Faker $faker) {
    return [
        "nip" => $faker->numberBetween(111111111,99999999),
        "kelas_id" => $faker->numberBetween(1,2),
        "nama" => $faker->name,
        "point_pelanggaran" => $faker->randomNumber(2),
        "point_penghargaan"=> $faker->randomNumber(2),
    ];
});
