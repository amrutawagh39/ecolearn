@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2>Leaderboard</h2>
        <p class="lead">See how you rank among other environmental champions</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Top Environmental Champions</h5>
                    <div class="btn-group">
                        <a href="{{ route('leaderboard.index', ['timeframe' => 'all_time']) }}"
                           class="btn btn-sm {{ $timeframe == 'all_time' ? 'btn-primary' : 'btn-outline-primary' }}">
                            All Time
                        </a>
                        <a href="{{ route('leaderboard.index', ['timeframe' => 'monthly']) }}"
                           class="btn btn-sm {{ $timeframe == 'monthly' ? 'btn-primary' : 'btn-outline-primary' }}">
                            This Month
                        </a>
                        <a href="{{ route('leaderboard.index', ['timeframe' => 'weekly']) }}"
                           class="btn btn-sm {{ $timeframe == 'weekly' ? 'btn-primary' : 'btn-outline-primary' }}">
                            This Week
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="60">Rank</th>
                                <th>Student</th>
                                <th>School</th>
                                <th>Level</th>
                                <th>Eco Points</th>
                                <th>Badges</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaderboard as $index => $user)
                            <tr class="{{ Auth::id() == $user->id ? 'table-success' : '' }}">
                                <td class="text-center">
                                    @if($index == 0)
                                        <span class="badge bg-warning text-dark">🥇</span>
                                    @elseif($index == 1)
                                        <span class="badge bg-secondary">🥈</span>
                                    @elseif($index == 2)
                                        <span class="badge bg-danger">🥉</span>
                                    @else
                                        <strong>#{{ $index + 1 }}</strong>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                                 alt="{{ $user->name }}"
                                                 class="rounded-circle"
                                                 width="40"
                                                 height="40">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <strong>{{ $user->name }}</strong>
                                            @if(Auth::id() == $user->id)
                                                <span class="badge bg-info ms-1">You</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->school_name }}</td>
                                <td>
                                    <span class="level-badge">Level {{ $user->level }}</span>
                                </td>
                                <td class="eco-points">{{ $user->eco_points }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $user->badges_count ?? 0 }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $leaderboard->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Current User Stats -->
@auth
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Your Ranking</h5>
            </div>
            <div class="card-body text-center">
                @php
                    $userRank = $leaderboard->firstWhere('id', Auth::id())
                                ? array_search(Auth::id(), $leaderboard->pluck('id')->toArray()) + 1
                                : 'Not ranked';
                @endphp

                @if($userRank === 'Not ranked')
                    <div class="display-4 text-muted">-</div>
                    <p class="text-muted">Complete more activities to appear on the leaderboard!</p>
                @else
                    <div class="display-1 text-primary">{{ $userRank }}</div>
                    <p class="lead">out of {{ $leaderboard->total() }} participants</p>

                    @if($userRank <= 3)
                        <div class="alert alert-success">
                            <i class="fas fa-trophy me-2"></i>
                            Congratulations! You're in the top 3!
                        </div>
                    @elseif($userRank <= 10)
                        <div class="alert alert-info">
                            <i class="fas fa-star me-2"></i>
                            Great job! You're in the top 10!
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Next Level Progress</h5>
            </div>
            <div class="card-body">
                @php
                    $currentLevelPoints = (Auth::user()->level - 1) * 100;
                    $nextLevelPoints = Auth::user()->level * 100;
                    $progress = Auth::user()->eco_points - $currentLevelPoints;
                    $totalNeeded = $nextLevelPoints - $currentLevelPoints;
                    $percentage = ($progress / $totalNeeded) * 100;
                @endphp

                <h6>Level {{ Auth::user()->level }} → Level {{ Auth::user()->level + 1 }}</h6>
                <div class="progress mb-2" style="height: 20px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                         style="width: {{ $percentage }}%">
                        {{ number_format($percentage, 1) }}%
                    </div>
                </div>
                <p class="text-center mb-0">
                    {{ $progress }} / {{ $totalNeeded }} points
                    <br>
                    <small class="text-muted">{{ $totalNeeded - $progress }} points to next level</small>
                </p>
            </div>
        </div>
    </div>
</div>
@endauth
@endsection
