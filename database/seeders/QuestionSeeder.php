<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            // Materi 1: AI
            [
                "question" => "Apa kepanjangan dari singkatan AI?",
                "id_material" => 1
            ],
            [
                "question" => "Manakah di bawah ini yang merupakan contoh penerapan AI dalam kehidupan sehari-hari?",
                "id_material" => 1
            ],
            [
                "question" => "Apa tujuan utama dari pengembangan Artificial Intelligence?",
                "id_material" => 1
            ],
            
            // Materi 2: HTML
            [
                "question" => "Apa kepanjangan dari HTML?",
                "id_material" => 2
            ],
            [
                "question" => "Tag apa yang digunakan untuk membuat sebuah paragraf dalam HTML?",
                "id_material" => 2
            ],
            [
                "question" => "Manakah tag HTML di bawah ini yang benar digunakan untuk menyisipkan sebuah gambar?",
                "id_material" => 2
            ],
        ];

        DB::table('questions')->insert($array);
    }
}
