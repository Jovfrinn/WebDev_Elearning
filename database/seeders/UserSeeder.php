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
                "password" => bcrypt('admin123#*'),
                "id_role" => 3
            ],
        ];

        DB::table('users')->insert($array);
    }
}
