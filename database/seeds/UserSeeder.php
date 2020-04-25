<?php

use Illuminate\Database\Seeder;
use App\Models\UserModel;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserModel::class,5)->create();
    }
}
