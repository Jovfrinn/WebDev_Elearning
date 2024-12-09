<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultQuiz extends Model
{
    protected $table = 'result_quizzes';
    
    protected $fillable = [
        'id_material',
        'id_user',
        'totalQuestion',
        'correctAnswers',
        'score',
        'score',
        'questions',
        'resultAnswers',
    ];

    protected $casts = [
        'questions' => 'array', 
        'resultAnswers' => 'array', 
    ];
}
