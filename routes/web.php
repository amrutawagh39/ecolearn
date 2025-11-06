<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\TeacherDashboardController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected routes - ALL routes that require authentication should be inside this group
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Lessons
    Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/lessons/{id}', [LessonController::class, 'show'])->name('lessons.show');

    // Quizzes
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/{id}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quizzes/{id}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::post('/quizzes/{id}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quizzes/{id}/results', [QuizController::class, 'results'])->name('quizzes.results');
    Route::get('/my-quiz-attempts', [QuizController::class, 'userAttempts'])->name('quizzes.my-attempts');
    Route::get('/quiz-leaderboard/{quizId?}', [QuizController::class, 'leaderboard'])->name('quizzes.leaderboard');

    // Leaderboard
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    // Challenges (remove duplicates - keep only one set)
    Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
    Route::get('/challenges/{id}', [ChallengeController::class, 'show'])->name('challenges.show');
    Route::post('/challenges/{id}/start', [ChallengeController::class, 'start'])->name('challenges.start');
    Route::post('/challenges/{id}/complete', [ChallengeController::class, 'complete'])->name('challenges.complete');

    // Teacher Routes (only one set - remove duplicates)
    Route::prefix('teacher')->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
        Route::get('/students', [TeacherDashboardController::class, 'students'])->name('teacher.students');
        Route::get('/students/{id}/progress', [TeacherDashboardController::class, 'studentProgress'])->name('teacher.student.progress');
    });
});
