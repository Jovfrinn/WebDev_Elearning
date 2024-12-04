<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            [
                "id_user" => 1,
                "id_material" => 1,
                "joined_at" => now(),
            ],
        ];

        DB::table('material_users')->insert($array);
    }
}
