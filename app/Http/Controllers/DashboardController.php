<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Challenge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_points' => $user->eco_points,
            'level' => $user->level,
            'completed_lessons' => 0, // You can implement this
            'completed_challenges' => $user->userChallenges()->where('status', 'completed')->count(),
            'badges_earned' => $user->badges()->count(),
        ];

        $recentLessons = Lesson::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $activeChallenges = Challenge::where('is_active', true)
            ->whereNotIn('id', function($query) use ($user) {
                $query->select('challenge_id')
                    ->from('user_challenges')
                    ->where('user_id', $user->id)
                    ->where('status', 'completed');
            })
            ->take(3)
            ->get();

        return view('dashboard', compact('stats', 'recentLessons', 'activeChallenges'));
    }
}
