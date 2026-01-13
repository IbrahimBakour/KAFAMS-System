<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subject',
        'description',
        'difficulty_level',
        'admin_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the admin who created this quiz
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get all questions for this quiz
     */
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    /**
     * Get all student responses for this quiz
     */
    public function responses()
    {
        return $this->hasMany(StudentQuizResponse::class);
    }

    /**
     * Get completed responses only
     */
    public function completedResponses()
    {
        return $this->hasMany(StudentQuizResponse::class)->where('status', 'submitted');
    }
}
