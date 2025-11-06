<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'challenge_type',
        'task_description',
        'points_reward',
        'duration_days',
        'image_url',
        'is_active'
    ];

    protected $casts = [
        'points_reward' => 'integer',
        'duration_days' => 'integer',
        'is_active' => 'boolean'
    ];

    public function userChallenges()
    {
        return $this->hasMany(UserChallenge::class);
    }
}
