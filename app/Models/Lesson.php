<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'category',
        'difficulty_level',
        'duration_minutes',
        'image_url',
        'video_url',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_minutes' => 'integer'
    ];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
