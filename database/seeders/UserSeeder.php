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
                "name" => "user1",
                "email" => "user1@gmail.com",
                "password" => bcrypt('user1234'),
                "id_role" => 1
            ],
        ];

        DB::table('users')->insert($array);
    }
}
