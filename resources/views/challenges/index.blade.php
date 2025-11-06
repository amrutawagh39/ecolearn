@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2>Environmental Challenges</h2>
        <p class="lead">Complete challenges to earn eco points and make a real impact!</p>
    </div>
</div>

<div class="row">
    @foreach($challenges as $challenge)
    @php
        $userChallenge = $userChallenges[$challenge->id] ?? null;
        $status = $userChallenge ? $userChallenge->status : 'not_started';
    @endphp

    <div class="col-md-6 mb-4">
        <div class="card h-100 border-{{ $status == 'completed' ? 'success' : ($status == 'in_progress' ? 'warning' : 'primary') }}">
            <img src="{{ $challenge->image_url ?: 'https://via.placeholder.com/400x200' }}"
                 class="card-img-top"
                 alt="{{ $challenge->title }}"
                 style="height: 200px; object-fit: cover;">

            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title">{{ $challenge->title }}</h5>
                    <span class="badge bg-{{ $challenge->challenge_type == 'daily' ? 'info' : ($challenge->challenge_type == 'weekly' ? 'warning' : ($challenge->challenge_type == 'monthly' ? 'success' : 'secondary')) }}">
                        {{ ucfirst($challenge->challenge_type) }}
                    </span>
                </div>

                <p class="card-text flex-grow-1">{{ $challenge->description }}</p>

                <div class="task-description mb-3">
                    <strong>Task:</strong> {{ $challenge->task_description }}
                </div>

                <div class="challenge-meta mb-3">
                    <div class="row text-center">
                        <div class="col-6">
                            <strong>Reward</strong>
                            <div class="eco-points">{{ $challenge->points_reward }} pts</div>
                        </div>
                        <div class="col-6">
                            <strong>Duration</strong>
                            <div>{{ $challenge->duration_days }} days</div>
                        </div>
                    </div>
                </div>

                <div class="mt-auto">
                    @if($status == 'completed')
                        <button class="btn btn-success w-100" disabled>
                            <i class="fas fa-check-circle me-2"></i>Completed
                        </button>
                        <small class="text-muted">Completed on: {{ $userChallenge->completed_at->format('M j, Y') }}</small>

                    @elseif($status == 'in_progress')
                        <a href="{{ route('challenges.show', $challenge->id) }}" class="btn btn-warning w-100">
                            <i class="fas fa-play-circle me-2"></i>In Progress
                        </a>
                        <small class="text-muted">Started: {{ $userChallenge->started_at->format('M j, Y') }}</small>

                    @else
                        <form action="{{ route('challenges.start', $challenge->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-flag me-2"></i>Start Challenge
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($challenges->isEmpty())
<div class="text-center py-5">
    <div class="text-muted">
        <i class="fas fa-tasks fa-3x mb-3"></i>
        <h4>No challenges available at the moment</h4>
        <p>Check back later for new environmental challenges!</p>
    </div>
</div>
@endif
@endsection
