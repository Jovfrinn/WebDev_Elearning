<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            [
                "name" => "admin",
                "email" => "admin@gmail.com",
                "password" => bcrypt('password'),
                "id_role" => 3,
                "is_verified" => false,
                "nip" => null
            ],
            [
                "name" => "teacher",
                "email" => "teacher@gmail.com",
                "password" => bcrypt('password'),
                "id_role" => 2,
                "is_verified" => true,
                "nip" => 12345678
            ],
        ];

        DB::table('users')->insert($array);
    }
}
