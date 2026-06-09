<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            [
                "material_title" => "Apa itu AI",
                "material_image" => "AI.jpg",
                "description" => "AI adalah sebuah teknologi yang bisa berpikir sendiri dan bisa membantu manusia",
                "id_teacher" => 2,
                "created_at" => now(),
                "updated_at" => now()

            ],
            [
                "material_title" => "Apa itu HTML",
                "material_image" => "HTML.jpg",
                "description" => "HTML adalah sebuah markup language untuk membuat kerangka website",
                "id_teacher" => 2,
                "created_at" => now(),
                "updated_at" => now()
            ],
            
        ];

    DB::table('materials')->insert($array);

    }
}
