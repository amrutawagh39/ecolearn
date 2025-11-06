<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Teacher Dashboard - TEST</h1>
        <p>This is a test page to verify the teacher dashboard works.</p>
        <p>User: {{ Auth::user()->name }}</p>
        <p>Role: {{ Auth::user()->role }}</p>
        <p>School: {{ Auth::user()->school_name }}</p>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Quick Stats</h5>
            </div>
            <div class="card-body">
                <p>Total Students: {{ $stats['total_students'] }}</p>
                <p>Total Quizzes: {{ $stats['total_quizzes'] }}</p>
                <p>Total Lessons: {{ $stats['total_lessons'] }}</p>
                <p>Total Attempts: {{ $stats['total_attempts'] }}</p>
            </div>
        </div>

        <a href="/dashboard" class="btn btn-secondary mt-3">Go to Regular Dashboard</a>
    </div>
</body>
</html>
