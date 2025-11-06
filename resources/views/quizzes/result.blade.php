@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-{{ $passed ? 'success' : 'warning' }} text-white">
                <h4 class="mb-0 text-center">
                    @if($passed)
                        <i class="fas fa-trophy me-2"></i>Quiz Completed Successfully!
                    @else
                        <i class="fas fa-redo-alt me-2"></i>Quiz Attempt Completed
                    @endif
                </h4>
            </div>
            <div class="card-body">
                <!-- Quiz Summary -->
                <div class="row text-center mb-4">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5>Score</h5>
                                <div class="display-6 {{ $passed ? 'text-success' : 'text-warning' }}">
                                    {{ $attempt->score }}/{{ $attempt->total_questions * 10 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5>Correct Answers</h5>
                                <div class="display-6 text-primary">
                                    {{ $attempt->correct_answers }}/{{ $attempt->total_questions }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5>Percentage</h5>
                                <div class="display-6 {{ $percentage >= $quiz->passing_score ? 'text-success' : 'text-warning' }}">
                                    {{ $percentage }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Points Earned -->
                @if($passed && $pointsEarned > 0)
                <div class="alert alert-success text-center">
                    <h5>
                        <i class="fas fa-star me-2"></i>
                        You earned {{ $pointsEarned }} Eco Points!
                    </h5>
                    <p class="mb-0">Your total points are now: <strong>{{ Auth::user()->eco_points }}</strong></p>
                </div>
                @elseif(!$passed)
                <div class="alert alert-warning text-center">
                    <h5>
                        <i class="fas fa-info-circle me-2"></i>
                        Passing score is {{ $quiz->passing_score }}%
                    </h5>
                    <p class="mb-0">Keep trying! You can retake this quiz after 24 hours.</p>
                </div>
                @endif

                <!-- Question Review -->
                <h5 class="mb-3">Question Review</h5>
                @foreach($questionResults as $index => $result)
                <div class="card mb-3 border-{{ $result['is_correct'] ? 'success' : 'danger' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title mb-0">Question {{ $index + 1 }}</h6>
                            <span class="badge bg-{{ $result['is_correct'] ? 'success' : 'danger' }}">
                                {{ $result['is_correct'] ? '+' . $result['points'] . ' pts' : '0 pts' }}
                            </span>
                        </div>
                        <p class="card-text">{{ $result['question_text'] }}</p>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Your Answer:</strong>
                                <p class="{{ $result['is_correct'] ? 'text-success' : 'text-danger' }}">
                                    {{ $result['user_answer'] ?: 'No answer provided' }}
                                </p>
                            </div>
                            @if(!$result['is_correct'])
                            <div class="col-md-6">
                                <strong>Correct Answer:</strong>
                                <p class="text-success">{{ $result['correct_answer'] }}</p>
                            </div>
                            @endif
                        </div>

                        @if($result['explanation'])
                        <div class="alert alert-info mt-2">
                            <strong>Explanation:</strong> {{ $result['explanation'] }}
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach

                <!-- Action Buttons -->
                <div class="text-center mt-4">
                    <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-arrow-left me-1"></i> Back to Quiz
                    </a>
                    <a href="{{ route('quizzes.index') }}" class="btn btn-success me-2">
                        <i class="fas fa-list me-1"></i> Browse More Quizzes
                    </a>
                    @if($passed)
                    <a href="{{ route('leaderboard.index', ['quiz' => $quiz->id]) }}" class="btn btn-warning">
                        <i class="fas fa-trophy me-1"></i> View Leaderboard
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
