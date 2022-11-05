<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 'user' . Str::random(6),
                'name' => 'User Pertama',
                'username' => 'firstuser',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'remember_token' => Str::random(10),
            ],
            [
                'id' => 'user' . Str::random(6),
                'name' => 'User Kedua',
                'username' => 'seconduser',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'remember_token' => Str::random(10),
            ],
            [
                'id' => 'user' . Str::random(6),
                'name' => 'User Ketiga',
                'username' => 'thirduser',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'remember_token' => Str::random(10),
            ],
        ];

        \App\Models\User::insert($data);
    }
}
