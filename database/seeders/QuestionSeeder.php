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
            [
                "question" => "Anda sedang merancang sebuah aplikasi mobile untuk membantu pelajar SMK belajar pemrograman. Aplikasi ini ???",
                "id_material" => 1
            ],
            [
                "question" => "blah blahh loremm dfjaddfajdskf sdfkjadskfjd jdsfkadsjf ???",
                "id_material" => 1

            ],
            [
                "question" => "lorem ipsum dolor ahfihadsfkdhf dakfhdskfhadksjf kdjdfkjsddf sdfhkdasjf???",
                "id_material" => 1
            ],
            [
                "question" => "Anda sedang merancang sebuah aplikasi mobile untuk membantu pelajar SMK belajar pemrograman. Aplikasi ini ???",
                "id_material" => 2
            ],
            [
                "question" => "blah blahh loremm dfjaddfajdskf sdfkjadskfjd jdsfkadsjf ???",
                "id_material" => 2

            ],
            [
                "question" => "lorem ipsum dolor ahfihadsfkdhf dakfhdskfhadksjf kdjdfkjsddf sdfhkdasjf???",
                "id_material" => 2
            ],
            ];

    DB::table('questions')->insert($array);
    }
}
