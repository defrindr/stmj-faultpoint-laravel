<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // call seeder
        $this->call(UserSeeder::class);
        $this->call(BukuSeeder::class);
    }
}
