<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempQuiz extends Model
{
    protected $table = 'temp_quizzes';
    protected $fillable = ['user_id', 'id_material', 'current_question_index', 'answers'];
    
    protected $casts = [
        'answers' => 'array', 
    ];
}
