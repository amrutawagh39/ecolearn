@extends('layouts.app')

@section('content')
<div class="row">
    <!-- User Stats -->
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Your Level</h5>
                <div class="display-4 text-primary">{{ $stats['level'] }}</div>
                <p class="card-text">Environmental Champion</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Eco Points</h5>
                <div class="display-4 eco-points">{{ $stats['total_points'] }}</div>
                <p class="card-text">Points earned</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Challenges</h5>
                <div class="display-4 text-success">{{ $stats['completed_challenges'] }}</div>
                <p class="card-text">Completed</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Badges</h5>
                <div class="display-4 text-warning">{{ $stats['badges_earned'] }}</div>
                <p class="card-text">Earned</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Lessons -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Lessons</h5>
                <a href="{{ route('lessons.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                @foreach($recentLessons as $lesson)
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                        <img src="{{ $lesson->image_url ?: 'https://via.placeholder.com/60' }}"
                             alt="{{ $lesson->title }}"
                             class="rounded"
                             width="60"
                             height="60">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">{{ $lesson->title }}</h6>
                        <span class="category-badge">{{ ucfirst(str_replace('_', ' ', $lesson->category)) }}</span>
                        <small class="text-muted d-block">{{ $lesson->duration_minutes }} min</small>
                    </div>
                    <a href="{{ route('lessons.show', $lesson->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Active Challenges -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Active Challenges</h5>
                <a href="{{ route('challenges.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                @foreach($activeChallenges as $challenge)
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                        <img src="{{ $challenge->image_url ?: 'https://via.placeholder.com/60' }}"
                             alt="{{ $challenge->title }}"
                             class="rounded"
                             width="60"
                             height="60">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">{{ $challenge->title }}</h6>
                        <span class="badge bg-info">{{ ucfirst($challenge->challenge_type) }}</span>
                        <small class="text-muted d-block">{{ $challenge->points_reward }} points</small>
                    </div>
                    <a href="{{ route('challenges.show', $challenge->id) }}" class="btn btn-sm btn-success">Start</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Progress Section -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Your Progress</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <h6>Climate Change</h6>
                        <div class="progress">
                            <div class="progress-bar" style="width: 65%">65%</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <h6>Waste Management</h6>
                        <div class="progress">
                            <div class="progress-bar" style="width: 40%">40%</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <h6>Biodiversity</h6>
                        <div class="progress">
                            <div class="progress-bar" style="width: 30%">30%</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <h6>Water Conservation</h6>
                        <div class="progress">
                            <div class="progress-bar" style="width: 25%">25%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
