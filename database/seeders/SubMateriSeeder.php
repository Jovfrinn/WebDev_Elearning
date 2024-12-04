<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubMateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            [
                "id_material" => 1,
                "title" => "pengenalan AI",
                "description" => "Artificial Intelligence (AI) atau Kecerdasan Buatan adalah cabang ilmu komputer yang berfokus pada pembuatan sistem atau mesin yang dapat melakukan tugas yang biasanya membutuhkan kecerdasan manusia. Tugas ini meliputi pengenalan suara, pemahaman bahasa alami, pengambilan keputusan, pembelajaran dari data, dan bahkan kreativitas.",
                "file_material" => NULL
            ],
            [
                "id_material" => 1,
                "title" => "Belajar AI #1",
                "description" =>  NULL,
                "file_material" => "BelajarAI.mp4"
            ],
            [
                "id_material" => 2,
                "title" => "pengenalan HTML",
                "description" => "HTML adalah singkatan dari Hyper Text Markup Language yang berarti bahasa markup untuk website",
                "file_material" => NULL
            ],
            [
                "id_material" => 2,
                "title" => "Belajar HTML #1",
                "description" =>  NULL,
                "file_material" => "BelajarAI.mp4"
            ],
        ];

        DB::table('sub_materials')->insert($array);
    }
}
