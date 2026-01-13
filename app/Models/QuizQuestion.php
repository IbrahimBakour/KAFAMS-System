<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'order',
    ];

    /**
     * Get the quiz that owns this question
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the correct option letter
     */
    public function getCorrectAnswerAttribute()
    {
        $option = 'option_' . strtolower($this->correct_option);
        return $this->$option;
    }
}
