<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $tables = 'answers';
    protected $fillable = [
        'id_question',
        'choices',
        'correctAnswer',
    ];
    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }
}
