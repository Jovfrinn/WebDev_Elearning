<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'id_material',
        'question',
        'score',
    ];
    
    public function answers()
    {
        return $this->hasMany(Answer::class, 'id_question');
    }
}
