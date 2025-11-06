<?php
// app/Http/Controllers/LeaderboardController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $timeframe = $request->get('timeframe', 'all_time');

        $query = User::where('role', 'student');

        switch ($timeframe) {
            case 'weekly':
                $query->where('created_at', '>=', now()->subWeek());
                break;
            case 'monthly':
                $query->where('created_at', '>=', now()->subMonth());
                break;
        }

        $leaderboard = $query->orderBy('eco_points', 'desc')
            ->orderBy('level', 'desc')
            ->paginate(20);

        return view('leaderboard.index', compact('leaderboard', 'timeframe'));
    }
}
