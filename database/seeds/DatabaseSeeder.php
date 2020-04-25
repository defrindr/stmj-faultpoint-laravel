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
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserRolesSeeder::class);
        $this->call(HariEfektifSeeder::class);
        $this->call(HariTidakEfektifSeeder::class);
        $this->call(KategoriPointSeeder::class);
        $this->call(PointSeeder::class);
        $this->call(JurusanSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(SiswaSeeder::class);
    }
}
