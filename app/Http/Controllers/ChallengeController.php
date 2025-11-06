<?php
// app/Http/Controllers/ChallengeController.php
namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\UserChallenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get user's challenge progress
        $userChallenges = [];
        if (Auth::check()) {
            $userChallenges = UserChallenge::where('user_id', Auth::id())
                ->get()
                ->keyBy('challenge_id');
        }

        return view('challenges.index', compact('challenges', 'userChallenges'));
    }

    public function show($id)
    {
        $challenge = Challenge::findOrFail($id);
        $userChallenge = null;

        if (Auth::check()) {
            $userChallenge = UserChallenge::where('user_id', Auth::id())
                ->where('challenge_id', $id)
                ->first();
        }

        return view('challenges.show', compact('challenge', 'userChallenge'));
    }

    public function start($id)
    {
        $challenge = Challenge::findOrFail($id);
        $user = Auth::user();

        // Check if user already started this challenge
        $existingChallenge = UserChallenge::where('user_id', $user->id)
            ->where('challenge_id', $id)
            ->first();

        if (!$existingChallenge) {
            UserChallenge::create([
                'user_id' => $user->id,
                'challenge_id' => $id,
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
        }

        return redirect()->route('challenges.show', $id)
            ->with('success', 'Challenge started successfully!');
    }

    public function complete(Request $request, $id)
    {
        $request->validate([
            'proof_image' => 'nullable|image|max:2048',
            'notes' => 'nullable|string|max:1000',
        ]);

        $userChallenge = UserChallenge::where('user_id', Auth::id())
            ->where('challenge_id', $id)
            ->firstOrFail();

        // Handle proof image upload
        $proofImage = null;
        if ($request->hasFile('proof_image')) {
            $proofImage = $request->file('proof_image')->store('challenges', 'public');
        }

        $userChallenge->update([
            'status' => 'completed',
            'completed_at' => now(),
            'proof_image' => $proofImage,
            'notes' => $request->input('notes'),
        ]);

        // Award points to user
        $challenge = Challenge::findOrFail($id);
        Auth::user()->addPoints($challenge->points_reward);

        return redirect()->route('challenges.index')
            ->with('success', 'Challenge completed! You earned ' . $challenge->points_reward . ' points.');
    }
}
