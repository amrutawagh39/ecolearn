@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2>My Quiz Attempts</h2>
        <p class="lead">Track your quiz performance and progress</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Quiz History</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Quiz</th>
                        <th>Date</th>
                        <th>Score</th>
                        <th>Correct Answers</th>
                        <th>Percentage</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attempts as $attempt)
                    @php
                        $percentage = $attempt->total_questions > 0
                            ? round(($attempt->correct_answers / $attempt->total_questions) * 100, 2)
                            : 0;
                        $passed = $percentage >= $attempt->quiz->passing_score;
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $attempt->quiz->title }}</strong>
                            @if($attempt->quiz->lesson)
                            <br>
                            <small class="text-muted">Lesson: {{ $attempt->quiz->lesson->title }}</small>
                            @endif
                        </td>
                        <td>{{ $attempt->completed_at->format('M j, Y g:i A') }}</td>
                        <td>
                            <span class="fw-bold {{ $passed ? 'text-success' : 'text-warning' }}">
                                {{ $attempt->score }}/{{ $attempt->total_questions * 10 }}
                            </span>
                        </td>
                        <td>{{ $attempt->correct_answers }}/{{ $attempt->total_questions }}</td>
                        <td>
                            <span class="badge bg-{{ $passed ? 'success' : 'warning' }}">
                                {{ $percentage }}%
                            </span>
                        </td>
                        <td>
                            @if($passed)
                            <span class="badge bg-success">Passed</span>
                            @else
                            <span class="badge bg-warning text-dark">Failed</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('quizzes.results', $attempt->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i> View Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <h5>No quiz attempts yet</h5>
                                <p>Start taking quizzes to track your progress here!</p>
                                <a href="{{ route('quizzes.index') }}" class="btn btn-primary">
                                    Browse Quizzes
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($attempts->hasPages())
    <div class="card-footer">
        {{ $attempts->links() }}
    </div>
    @endif
</div>
@endsection
