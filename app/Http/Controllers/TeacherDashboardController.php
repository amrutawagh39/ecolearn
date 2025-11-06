<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        // Check if user is teacher
        if (Auth::user()->role !== 'teacher') {
            return redirect()->route('dashboard')->with('error', 'Access denied. Teacher access only.');
        }

        $teacher = Auth::user();

        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_quizzes' => Quiz::count(),
            'total_lessons' => Lesson::count(),
            'total_attempts' => QuizAttempt::count(),
        ];

        // Recent quiz attempts by students
        $recentAttempts = QuizAttempt::with(['user', 'quiz'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Student progress data
        $studentProgress = User::where('role', 'student')
            ->withCount(['quizAttempts'])
            ->orderBy('eco_points', 'desc')
            ->take(10)
            ->get();

        return view('teacher.dashboard', compact('stats', 'recentAttempts', 'studentProgress'));
    }

    public function students()
    {
        if (Auth::user()->role !== 'teacher') {
            return redirect()->route('dashboard')->with('error', 'Access denied. Teacher access only.');
        }

        $students = User::where('role', 'student')
            ->withCount(['quizAttempts', 'userChallenges'])
            ->orderBy('eco_points', 'desc')
            ->paginate(20);

        return view('teacher.students', compact('students'));
    }

    public function studentProgress($id)
    {
        if (Auth::user()->role !== 'teacher') {
            return redirect()->route('dashboard')->with('error', 'Access denied. Teacher access only.');
        }

        $student = User::with(['quizAttempts.quiz', 'userChallenges.challenge', 'badges'])
            ->findOrFail($id);

        return view('teacher.student-progress', compact('student'));
    }
}
