@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $challenge->title }}</h4>
                    <span class="badge bg-light text-primary">{{ ucfirst($challenge->challenge_type) }} Challenge</span>
                </div>
            </div>

            <div class="card-body">
                <!-- Challenge Header -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <img src="{{ $challenge->image_url ?: 'https://via.placeholder.com/600x300' }}"
                             alt="{{ $challenge->title }}"
                             class="img-fluid rounded">
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5>Challenge Details</h5>
                                <div class="display-6 eco-points mb-2">{{ $challenge->points_reward }}</div>
                                <p class="mb-1">Eco Points Reward</p>
                                <hr>
                                <p><i class="fas fa-clock me-2"></i><strong>Duration:</strong> {{ $challenge->duration_days }} days</p>
                                <p><i class="fas fa-trophy me-2"></i><strong>Status:</strong>
                                    @if($userChallenge)
                                        <span class="badge bg-{{ $userChallenge->status == 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst(str_replace('_', ' ', $userChallenge->status)) }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Not Started</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Challenge Description -->
                <div class="mb-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Description</h5>
                    <p class="lead">{{ $challenge->description }}</p>
                </div>

                <!-- Your Task -->
                <div class="mb-4">
                    <h5><i class="fas fa-tasks me-2"></i>Your Task</h5>
                    <div class="alert alert-info">
                        <i class="fas fa-bullseye me-2"></i>
                        <strong>Objective:</strong> {{ $challenge->task_description }}
                    </div>
                </div>

                <!-- Practical Solutions Section -->
                <div class="mb-4">
                    <h5><i class="fas fa-lightbulb me-2"></i>How to Complete This Challenge</h5>
                    <div class="card">
                        <div class="card-body">
                            @if($challenge->id == 1) {{-- Plant a Tree --}}
                            <ul>
                                <li>🌱 Plant a sapling in your garden, school, or community area</li>
                                <li>🌳 Adopt and care for an existing tree in your neighborhood</li>
                                <li>👥 Join a local tree plantation drive</li>
                                <li>🏡 Grow plants from seeds in pots at home</li>
                            </ul>
                            <p class="text-muted"><strong>Proof Idea:</strong> Photo of you planting or with the planted tree</p>

                            @elseif($challenge->id == 2) {{-- Plastic-Free Day --}}
                            <ul>
                                <li>🛍️ Use cloth bags instead of plastic for shopping</li>
                                <li>💧 Carry reusable water bottle</li>
                                <li>🍱 Use steel/glass containers for food</li>
                                <li>🚫 Say no to plastic straws and cutlery</li>
                                <li>🌿 Use bamboo toothbrush</li>
                            </ul>
                            <p class="text-muted"><strong>Proof Idea:</strong> Photo of your plastic-free alternatives</p>

                            @elseif($challenge->id == 3) {{-- Water Conservation --}}
                            <ul>
                                <li>🚿 Take bucket baths instead of showers</li>
                                <li>💦 Turn off tap while brushing teeth</li>
                                <li>🌧️ Collect rainwater for plants</li>
                                <li>🔧 Fix leaking taps immediately</li>
                                <li>☀️ Use mug instead of running tap</li>
                            </ul>
                            <p class="text-muted"><strong>Proof Idea:</strong> Photo/video of water-saving practices</p>

                            @elseif($challenge->id == 4) {{-- Energy Audit --}}
                            <ul>
                                <li>💡 Switch to LED bulbs in 2+ rooms</li>
                                <li>🔌 Unplug chargers when not in use</li>
                                <li>☀️ Use natural light during daytime</li>
                                <li>❄️ Set AC to 24°C or higher</li>
                                <li>👕 Air dry clothes instead of using dryer</li>
                            </ul>
                            <p class="text-muted"><strong>Proof Idea:</strong> Before/after photos or electricity bill</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Completion Form -->
                @if($userChallenge && $userChallenge->status == 'in_progress')
                <div class="complete-challenge-section">
                    <h5><i class="fas fa-check-circle me-2"></i>Complete This Challenge</h5>
                    <div class="card border-success">
                        <div class="card-body">
                            <form action="{{ route('challenges.complete', $challenge->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="proof_image" class="form-label">Upload Proof (Optional but Recommended)</label>
                                    <input type="file" class="form-control" id="proof_image" name="proof_image" accept="image/*">
                                    <div class="form-text">Upload a photo showing you completed the challenge. This helps us verify your participation.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Share Your Experience</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3"
                                              placeholder="Tell us about your experience, what you learned, or any challenges you faced..."></textarea>
                                    <div class="form-text">Your insights help inspire others!</div>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-check-circle me-2"></i>Mark as Completed & Claim {{ $challenge->points_reward }} Points
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Start Challenge Button -->
                @if(!$userChallenge)
                <div class="text-center">
                    <form action="{{ route('challenges.start', $challenge->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-flag me-2"></i>Start This Challenge
                        </button>
                    </form>
                    <p class="text-muted mt-2">You'll have {{ $challenge->duration_days }} days to complete this challenge</p>
                </div>
                @endif
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('challenges.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to All Challenges
                    </a>

                    @if($userChallenge && $userChallenge->status == 'completed')
                    <span class="text-success">
                        <i class="fas fa-check-circle me-2"></i>Completed on {{ $userChallenge->completed_at->format('F j, Y') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
