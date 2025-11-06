<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'title',
        'description',
        'questions_count',
        'time_limit_minutes',
        'passing_score',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'questions_count' => 'integer',
        'time_limit_minutes' => 'integer',
        'passing_score' => 'integer'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
