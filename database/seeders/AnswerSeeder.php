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
            [
                "id_question" => 1,
                "choices" => "jawaban a",
                "correctAnswer" => 1,
            ],
            [
                "id_question" => 1,
                "choices" => "jawaban b",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 1,
                "choices" => "jawaban c",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 1,
                "choices" => "jawaban d",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 2,
                "choices" => "jawaban a",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 2,
                "choices" => "jawaban b",
                "correctAnswer" => 1,
            ],
            [
                "id_question" => 2,
                "choices" => "jawaban c",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 2,
                "choices" => "jawaban d",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 3,
                "choices" => "jawaban a",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 3,
                "choices" => "jawaban b",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 3,
                "choices" => "jawaban c",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 3,
                "choices" => "jawaban d",
                "correctAnswer" => 1,
            ],
            [
                "id_question" => 4,
                "choices" => "jawaban a",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 4,
                "choices" => "jawaban b",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 4,
                "choices" => "jawaban c",
                "correctAnswer" => 1,
            ],
            [
                "id_question" => 4,
                "choices" => "jawaban d",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 5,
                "choices" => "oke gas oke gas oke gas oke gasss",
                "correctAnswer" => 1,
            ],
            [
                "id_question" => 5,
                "choices" => "mang eak mang eak mang eak mang eak",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 5,
                "choices" => "apaan tuhh appann tuh apaan tuh apaan tuh",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 5,
                "choices" => "hayuuk hayuuk hayukkkjk hayukkkkk hayukkkkkkkkkkkkkkk",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 6,
                "choices" => "ashiipppp siapodhfoadsf",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 6,
                "choices" => "mang wokwokw wowokwowkw owkwowko mang ",
                "correctAnswer" => 0,
            ],
            [
                "id_question" => 6,
                "choices" => "apaan tuhh appann tuh shnfjdhf jdhfkjadsfh",
                "correctAnswer" => 1,
            ],
            [
                "id_question" => 6,
                "choices" => "hayuuk hayuuk hayukkkjk jhzdfkjhadfj",
                "correctAnswer" => 0,
            ],
    ];

    FacadesDB::table('answers')->insert($array);
    }
}
