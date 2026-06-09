<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            // Question 1 (AI): Apa kepanjangan dari singkatan AI?
            [
                "id_question" => 1,
                "choices" => "Artificial Intelligence",
                "correctAnswer" => 1,
            ],
            [
                "id_question" => 1,
                "choices" => "Automated Integration",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 1,
                "choices" => "Advanced Information",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 1,
                "choices" => "Artistic Illusion",
                "correctAnswer" => 0,
            ],
            
            // Question 2 (AI): Contoh penerapan AI?
            [
                "id_question" => 2,
                "choices" => "Mesin ketik manual",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 2,
                "choices" => "Asisten virtual (seperti Siri atau Google Assistant)",
                "correctAnswer" => 1,
            ],
            [
                "id_question" => 2,
                "choices" => "Kipas angin tradisional",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 2,
                "choices" => "Buku cetak",
                "correctAnswer" => 0,
            ],
            
            // Question 3 (AI): Tujuan utama AI?
            [
                "id_question" => 3,
                "choices" => "Membuat komputer menjadi lebih berat",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 3,
                "choices" => "Menghapus semua pekerjaan manusia di bumi",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 3,
                "choices" => "Membuat komputer mampu meniru kemampuan kognitif manusia",
                "correctAnswer" => 1,
            ],
            [
                "id_question" => 3,
                "choices" => "Menghasilkan lebih banyak polusi udara",
                "correctAnswer" => 0,
            ],
            
            // Question 4 (HTML): Apa kepanjangan HTML?
            [
                "id_question" => 4,
                "choices" => "Hyper Text Markup Language",
                "correctAnswer" => 1,
            ],
            [
                "id_question" => 4,
                "choices" => "High Tech Modern Language",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 4,
                "choices" => "Hyperlinks and Text Markup Language",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 4,
                "choices" => "Home Tool Markup Language",
                "correctAnswer" => 0,
            ],
            
            // Question 5 (HTML): Tag untuk paragraf?
            [
                "id_question" => 5,
                "choices" => "<paragraph>",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 5,
                "choices" => "<pg>",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 5,
                "choices" => "<p>",
                "correctAnswer" => 1,
            ],
            [
                "id_question" => 5,
                "choices" => "<text>",
                "correctAnswer" => 0,
            ],
            
            // Question 6 (HTML): Tag untuk gambar?
            [
                "id_question" => 6,
                "choices" => "<image src='url' />",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 6,
                "choices" => "<img src='url' alt='text'>",
                "correctAnswer" => 1,
            ],
            [
                "id_question" => 6,
                "choices" => "<picture href='url'>",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 6,
                "choices" => "<pic source='url'>",
                "correctAnswer" => 0,
            ],
        ];

        FacadesDB::table('answers')->insert($array);
    }
}
