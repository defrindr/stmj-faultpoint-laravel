<?php

use Illuminate\Database\Seeder;
use App\Models\UserRoles;


class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                "user_id" => 1,
                "role_id" => 1
            ],
            [
                "user_id" => 2,
                "role_id" => 3
            ],
            [
                "user_id" => 3,
                "role_id" => 3
            ],
            [
                "user_id" => 4,
                "role_id" => 4
            ],
            [
                "user_id" => 5,
                "role_id" => 4
            ],
            [
                "user_id" => 6,
                "role_id" => 2
            ],
        ];

        foreach($role as $row){
            userRoles::create($row);
        }
    }
}
