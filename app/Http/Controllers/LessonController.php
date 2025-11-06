<?php
// app/Http/Controllers/LessonController.php
namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $categories = [
            'climate_change' => 'Climate Change',
            'biodiversity' => 'Biodiversity',
            'waste_management' => 'Waste Management',
            'water_conservation' => 'Water Conservation',
            'energy' => 'Energy Conservation'
        ];

        $lessons = Lesson::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('category');

        return view('lessons.index', compact('lessons', 'categories'));
    }

    public function show($id)
    {
        $lesson = Lesson::with('quizzes')->findOrFail($id);
        $relatedLessons = Lesson::where('category', $lesson->category)
            ->where('id', '!=', $id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return view('lessons.show', compact('lesson', 'relatedLessons'));
    }
}
