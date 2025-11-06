@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2>Environmental Quizzes</h2>
        <p class="lead">Test your knowledge and earn eco points!</p>
    </div>
</div>

@if($quizzes->count() > 0)
<div class="row">
    @foreach($quizzes as $quiz)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $quiz->title }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $quiz->description }}</p>

                <div class="quiz-details mb-3">
                    <div class="row text-center">
                        <div class="col-4">
                            <strong>Questions</strong>
                            <div>{{ $quiz->questions_count }}</div>
                        </div>
                        <div class="col-4">
                            <strong>Time</strong>
                            <div>{{ $quiz->time_limit_minutes }} min</div>
                        </div>
                        <div class="col-4">
                            <strong>Passing</strong>
                            <div>{{ $quiz->passing_score }}%</div>
                        </div>
                    </div>
                </div>

                @if($quiz->lesson)
                <p class="mb-2">
                    <strong>Category:</strong>
                    <span class="badge bg-info">
                        {{ ucfirst(str_replace('_', ' ', $quiz->lesson->category)) }}
                    </span>
                </p>
                @endif

                @php
                    $userAttempt = $userAttempts[$quiz->id] ?? null;
                @endphp

                @if($userAttempt)
                    @php
                        $percentage = $userAttempt->total_questions > 0
                            ? round(($userAttempt->correct_answers / $userAttempt->total_questions) * 100)
                            : 0;
                    @endphp

                    @if($percentage >= $quiz->passing_score)
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            Completed: {{ $percentage }}%
                        </div>
                        <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-redo me-1"></i> Retake Quiz
                        </a>
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Score: {{ $percentage }}%
                        </div>
                        <a href="{{ route('quizzes.start', $quiz->id) }}" class="btn btn-warning w-100">
                            <i class="fas fa-play-circle me-1"></i> Try Again
                        </a>
                    @endif
                @else
                    <a href="{{ route('quizzes.start', $quiz->id) }}" class="btn btn-primary w-100">
                        <i class="fas fa-play me-1"></i> Start Quiz
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-5">
    <div class="alert alert-info">
        <i class="fas fa-info-circle fa-2x mb-3"></i>
        <h4>No quizzes available yet</h4>
        <p class="mb-0">Check back later for new environmental quizzes!</p>
    </div>
</div>
@endif
@endsection
