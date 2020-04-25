<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = [
            [
                'name' => "Super Admin",
                'email' => "admin@admin.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$04cYdcJ9bu/BQh9br212/.aHGRNGz8at9nCAMAN1hwf7rT5ZteE8y', // admin1234
                'remember_token' => Str::random(10)
            ],
            [
                'name' => "walikelas 1",
                'email' => "wk1@gmail.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$04cYdcJ9bu/BQh9br212/.aHGRNGz8at9nCAMAN1hwf7rT5ZteE8y', // admin1234
                'remember_token' => Str::random(10)
            ],
            [
                'name' => "walikelas 2",
                'email' => "wk2@gmail.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$04cYdcJ9bu/BQh9br212/.aHGRNGz8at9nCAMAN1hwf7rT5ZteE8y', // admin1234
                'remember_token' => Str::random(10)
            ],
            [
                'name' => "guru bk1",
                'email' => "bk1@gmail.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$04cYdcJ9bu/BQh9br212/.aHGRNGz8at9nCAMAN1hwf7rT5ZteE8y', // admin1234
                'remember_token' => Str::random(10)
            ],
            [
                'name' => "guru bk2",
                'email' => "bk2@gmail.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$04cYdcJ9bu/BQh9br212/.aHGRNGz8at9nCAMAN1hwf7rT5ZteE8y', // admin1234
                'remember_token' => Str::random(10)
            ],
            [
                'name' => "absensi",
                'email' => "absensi@gmail.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$04cYdcJ9bu/BQh9br212/.aHGRNGz8at9nCAMAN1hwf7rT5ZteE8y', // admin1234
                'remember_token' => Str::random(10)
            ],
        ];

        foreach($user as $row){
            User::create($row);
        }
    }
}
