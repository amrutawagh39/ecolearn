<?php
// app/Http/Controllers/QuizController.php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    public function index()
    {
        try {
            $quizzes = Quiz::with(['lesson', 'questions'])
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->get();

            // Get user's quiz attempts to show progress
            $userAttempts = [];
            if (Auth::check()) {
                $userAttempts = QuizAttempt::where('user_id', Auth::id())
                    ->get()
                    ->keyBy('quiz_id');
            }

            return view('quizzes.index', compact('quizzes', 'userAttempts'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load quizzes: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $quiz = Quiz::with(['questions', 'lesson'])
                ->where('is_active', true)
                ->findOrFail($id);

            // Check if user has already attempted this quiz
            $previousAttempt = null;
            if (Auth::check()) {
                $previousAttempt = QuizAttempt::where('user_id', Auth::id())
                    ->where('quiz_id', $id)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            return view('quizzes.show', compact('quiz', 'previousAttempt'));
        } catch (\Exception $e) {
            return redirect()->route('quizzes.index')->with('error', 'Quiz not found.');
        }
    }

    public function start($id)
    {
        try {
            $quiz = Quiz::with(['questions' => function($query) {
                $query->where('is_active', true);
            }])->where('is_active', true)->findOrFail($id);

            // Check if user has already completed this quiz recently
            $recentAttempt = QuizAttempt::where('user_id', Auth::id())
                ->where('quiz_id', $id)
                ->where('completed_at', '>=', now()->subHours(24))
                ->first();

            if ($recentAttempt) {
                return redirect()->route('quizzes.show', $id)
                    ->with('info', 'You have already attempted this quiz recently. Please try again after 24 hours.');
            }

            // Check if quiz has questions
            if ($quiz->questions->isEmpty()) {
                return redirect()->route('quizzes.show', $id)
                    ->with('error', 'This quiz currently has no questions available.');
            }

            // Update questions count
            $quiz->update(['questions_count' => $quiz->questions->count()]);

            return view('quizzes.take', compact('quiz'));

        } catch (\Exception $e) {
            return redirect()->route('quizzes.index')->with('error', 'Failed to start quiz: ' . $e->getMessage());
        }
    }

    public function submit(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'answers' => 'sometimes|array',
                'answers.*' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $quiz = Quiz::with('questions')->findOrFail($id);
            $user = Auth::user();
            $answers = $request->input('answers', []);

            $score = 0;
            $correctAnswers = 0;
            $totalQuestions = $quiz->questions->count();
            $questionResults = [];

            // Calculate score
            foreach ($quiz->questions as $question) {
                $userAnswer = $answers[$question->id] ?? null;
                $isCorrect = false;

                if ($userAnswer && $this->checkAnswer($question, $userAnswer)) {
                    $score += $question->points;
                    $correctAnswers++;
                    $isCorrect = true;
                }

                $questionResults[] = [
                    'question_id' => $question->id,
                    'question_text' => $question->question_text,
                    'user_answer' => $userAnswer,
                    'correct_answer' => $question->correct_answer,
                    'is_correct' => $isCorrect,
                    'points' => $isCorrect ? $question->points : 0,
                    'explanation' => $question->explanation,
                ];
            }

            // Calculate percentage
            $percentage = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

            // Save attempt
            $attempt = QuizAttempt::create([
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'score' => $score,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'time_taken_seconds' => $request->input('time_taken', 0),
                'completed_at' => now(),
            ]);

            $pointsEarned = 0;
            $passed = false;

            // Award points if passed
            if ($percentage >= $quiz->passing_score) {
                $passed = true;
                $pointsEarned = $score + 25; // Base points + completion bonus
                $user->addPoints($pointsEarned);

                // Check for perfect score bonus
                if ($correctAnswers === $totalQuestions) {
                    $perfectBonus = 50;
                    $pointsEarned += $perfectBonus;
                    $user->addPoints($perfectBonus);
                }
            }

            DB::commit();

            return view('quizzes.result', compact(
                'quiz',
                'attempt',
                'percentage',
                'pointsEarned',
                'questionResults',
                'passed'
            ));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('quizzes.show', $id)
                ->with('error', 'Failed to submit quiz: ' . $e->getMessage());
        }
    }

    public function results($attemptId)
    {
        try {
            $attempt = QuizAttempt::with(['quiz', 'quiz.questions', 'user'])
                ->where('user_id', Auth::id())
                ->findOrFail($attemptId);

            $percentage = $attempt->total_questions > 0
                ? round(($attempt->correct_answers / $attempt->total_questions) * 100, 2)
                : 0;

            return view('quizzes.attempt-detail', compact('attempt', 'percentage'));

        } catch (\Exception $e) {
            return redirect()->route('quizzes.index')->with('error', 'Attempt not found.');
        }
    }

    public function userAttempts()
    {
        try {
            $attempts = QuizAttempt::with('quiz')
                ->where('user_id', Auth::id())
                ->orderBy('completed_at', 'desc')
                ->paginate(10);

            return view('quizzes.user-attempts', compact('attempts'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load your quiz attempts.');
        }
    }

    private function checkAnswer(Question $question, $userAnswer)
    {
        $correctAnswer = strtolower(trim($question->correct_answer));
        $userAnswer = strtolower(trim($userAnswer));

        switch ($question->question_type) {
            case 'multiple_choice':
            case 'true_false':
                return $userAnswer === $correctAnswer;

            case 'short_answer':
                return $this->checkShortAnswer($correctAnswer, $userAnswer);

            default:
                return false;
        }
    }

    private function checkShortAnswer($correctAnswer, $userAnswer)
    {
        // Handle multiple correct answers separated by commas
        $correctAnswers = array_map('trim', explode(',', $correctAnswer));
        $correctAnswers = array_map('strtolower', $correctAnswers);

        // Check if user answer matches any of the correct answers
        if (in_array($userAnswer, $correctAnswers)) {
            return true;
        }

        // Check for keyword matching as fallback
        foreach ($correctAnswers as $correct) {
            if (strpos($userAnswer, $correct) !== false) {
                return true;
            }
        }

        return false;
    }

    public function leaderboard($quizId = null)
    {
        try {
            $query = QuizAttempt::with(['user', 'quiz'])
                ->select('user_id', 'quiz_id')
                ->selectRaw('MAX(score) as best_score')
                ->selectRaw('MAX(correct_answers) as best_correct')
                ->selectRaw('MIN(time_taken_seconds) as best_time')
                ->whereHas('quiz', function($q) {
                    $q->where('is_active', true);
                })
                ->groupBy('user_id', 'quiz_id');

            if ($quizId) {
                $quiz = Quiz::findOrFail($quizId);
                $query->where('quiz_id', $quizId);
                $leaderboard = $query->orderBy('best_score', 'desc')
                    ->orderBy('best_time', 'asc')
                    ->paginate(20);
            } else {
                // Overall leaderboard across all quizzes
                $query = User::where('role', 'student')
                    ->select('id', 'name', 'eco_points', 'level', 'school_name')
                    ->selectRaw('(SELECT COUNT(*) FROM quiz_attempts WHERE quiz_attempts.user_id = users.id) as quizzes_completed')
                    ->selectRaw('(SELECT AVG(score) FROM quiz_attempts WHERE quiz_attempts.user_id = users.id) as avg_score')
                    ->orderBy('eco_points', 'desc')
                    ->orderBy('level', 'desc')
                    ->paginate(20);

                $leaderboard = $query;
            }

            $quizzes = Quiz::where('is_active', true)->get();

            return view('quizzes.leaderboard', compact('leaderboard', 'quizzes', 'quizId'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load leaderboard.');
        }
    }
}
