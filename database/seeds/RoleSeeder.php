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
                "nama" => "Admin Absensi"
            ],
            [
                "nama" => "Wali Kelas"
            ],
            [
                "nama" => "Admin Tatib"
            ],
        ];
        foreach($roles as $role){
            Role::create($role);
        }
    }
}
