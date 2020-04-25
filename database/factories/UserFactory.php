<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserModel;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(UserModel::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$04cYdcJ9bu/BQh9br212/.aHGRNGz8at9nCAMAN1hwf7rT5ZteE8y', // admin1234
        'remember_token' => Str::random(10),
    ];
});
