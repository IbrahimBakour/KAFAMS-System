<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuizResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'student_id',
        'answers',
        'score',
        'total_questions',
        'status',
        'submitted_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'submitted_at' => 'datetime',
    ];

    /**
     * Get the quiz this response belongs to
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the student who submitted this response
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Calculate percentage score
     */
    public function getPercentageAttribute()
    {
        if ($this->total_questions > 0) {
            return round(($this->score / $this->total_questions) * 100, 2);
        }
        return 0;
    }

    /**
     * Check if quiz is passed (assuming 50% is passing)
     */
    public function getIsPassedAttribute()
    {
        return $this->percentage >= 50;
    }
}
