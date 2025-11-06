<?php
// database/seeders/QuizSeeder.php
namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run()
    {
        // Get actual lesson IDs
        $climateLesson = Lesson::where('title', 'Understanding Climate Change')->first();
        $wasteLesson = Lesson::where('title', 'Waste Segregation Basics')->first();
        $biodiversityLesson = Lesson::where('title', 'Biodiversity Conservation')->first();

        $quizzes = [
            [
                'lesson_id' => $climateLesson ? $climateLesson->id : null,
                'title' => 'Climate Change Basics Quiz',
                'description' => 'Test your knowledge about climate change fundamentals',
                'questions_count' => 3,
                'time_limit_minutes' => 10,
                'passing_score' => 60,
                'is_active' => true,
            ],
            [
                'lesson_id' => $wasteLesson ? $wasteLesson->id : null,
                'title' => 'Waste Management Quiz',
                'description' => 'Check your understanding of waste segregation and recycling',
                'questions_count' => 2,
                'time_limit_minutes' => 10,
                'passing_score' => 70,
                'is_active' => true,
            ],
            [
                'lesson_id' => $biodiversityLesson ? $biodiversityLesson->id : null,
                'title' => 'Biodiversity Assessment',
                'description' => 'Evaluate your knowledge about biodiversity conservation',
                'questions_count' => 6,
                'time_limit_minutes' => 12,
                'passing_score' => 65,
                'is_active' => true,
            ],
            [
                'lesson_id' => null,
                'title' => 'Environmental Awareness Test',
                'description' => 'General environmental knowledge quiz',
                'questions_count' => 5,
                'time_limit_minutes' => 15,
                'passing_score' => 60,
                'is_active' => true,
            ],
        ];

        foreach ($quizzes as $quiz) {
            Quiz::updateOrCreate(
                ['title' => $quiz['title']],
                $quiz
            );
        }

        $this->command->info('Quizzes seeded successfully!');
    }
}
