<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'school_name',
        'grade_level',
        'eco_points',
        'level',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function userChallenges()
    {
        return $this->hasMany(UserChallenge::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withTimestamps();
    }

    public function addPoints($points)
    {
        $this->eco_points += $points;

        // Level up logic
        $newLevel = floor($this->eco_points / 100) + 1;
        if ($newLevel > $this->level) {
            $this->level = $newLevel;
        }

        $this->save();
    }
}
