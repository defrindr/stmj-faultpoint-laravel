<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                "nama" => "Super Admin"
            ],
            [
                "nama" => "Petugas Absensi"
            ],
            [
                "nama" => "Wali Kelas"
            ],
            [
                "nama" => "Petugas Konseling"
            ],
        ];
        foreach($roles as $role){
            Role::create($role);
        }
    }
}
