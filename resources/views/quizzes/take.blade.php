@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $quiz->title }}</h4>
                    <div id="timer" class="badge bg-warning text-dark">
                        @if($quiz->time_limit_minutes)
                            {{ $quiz->time_limit_minutes }}:00
                        @else
                            No time limit
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="quiz-form" method="POST" action="{{ route('quizzes.submit', $quiz->id) }}">
                    @csrf
                    <input type="hidden" name="time_taken" id="time_taken" value="0">

                    @foreach($quiz->questions as $index => $question)
                    <div class="question mb-4 p-3 border rounded">
                        <h5 class="mb-3">Question {{ $index + 1 }}: {{ $question->question_text }}</h5>

                        @if($question->question_type == 'multiple_choice')
                            @php
                                // Safely handle options
                                $options = is_array($question->options) ? $question->options : json_decode($question->options, true) ?? [];
                            @endphp

                            @if(!empty($options))
                                @foreach($options as $option)
                                <div class="form-check mb-2">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="answers[{{ $question->id }}]"
                                           id="q{{ $question->id }}_{{ $loop->index }}"
                                           value="{{ $option }}"
                                           required>
                                    <label class="form-check-label" for="q{{ $question->id }}_{{ $loop->index }}">
                                        {{ $option }}
                                    </label>
                                </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning">
                                    No options available for this question.
                                </div>
                            @endif

                        @elseif($question->question_type == 'true_false')
                            <div class="form-check mb-2">
                                <input class="form-check-input"
                                       type="radio"
                                       name="answers[{{ $question->id }}]"
                                       id="q{{ $question->id }}_true"
                                       value="true"
                                       required>
                                <label class="form-check-label" for="q{{ $question->id }}_true">
                                    True
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input"
                                       type="radio"
                                       name="answers[{{ $question->id }}]"
                                       id="q{{ $question->id }}_false"
                                       value="false"
                                       required>
                                <label class="form-check-label" for="q{{ $question->id }}_false">
                                    False
                                </label>
                            </div>

                        @elseif($question->question_type == 'short_answer')
                            <div class="mb-3">
                                <input type="text"
                                       class="form-control"
                                       name="answers[{{ $question->id }}]"
                                       placeholder="Type your answer here..."
                                       required>
                            </div>
                        @endif

                        <small class="text-muted">{{ $question->points }} points</small>
                    </div>
                    @endforeach

                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg">Submit Quiz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($quiz->time_limit_minutes)
@push('scripts')
<script>
    let timeLeft = {{ $quiz->time_limit_minutes * 60 }};
    const timerElement = document.getElementById('timer');
    const timeTakenInput = document.getElementById('time_taken');
    const quizForm = document.getElementById('quiz-form');
    let startTime = Date.now();

    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        // Update time taken
        const elapsedSeconds = Math.floor((Date.now() - startTime) / 1000);
        timeTakenInput.value = elapsedSeconds;

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            alert('Time is up! Submitting your quiz...');
            quizForm.submit();
        }

        timeLeft--;
    }

    const timerInterval = setInterval(updateTimer, 1000);
    updateTimer(); // Initial call
</script>
@endpush
@endif
@endsection
