@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2>Environmental Lessons</h2>
        <p class="lead">Learn about environmental issues through interactive lessons</p>
    </div>
</div>

@foreach($categories as $key => $category)
@if(isset($lessons[$key]) && $lessons[$key]->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-3">{{ $category }}</h4>
        <div class="row">
            @foreach($lessons[$key] as $lesson)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ $lesson->image_url ?: 'https://via.placeholder.com/300x200' }}"
                         class="card-img-top"
                         alt="{{ $lesson->title }}"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $lesson->title }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($lesson->description, 100) }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-secondary">{{ ucfirst($lesson->difficulty_level) }}</span>
                                <small class="text-muted">{{ $lesson->duration_minutes }} min</small>
                            </div>
                            <a href="{{ route('lessons.show', $lesson->id) }}" class="btn btn-primary w-100">Start Lesson</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endforeach
@endsection
