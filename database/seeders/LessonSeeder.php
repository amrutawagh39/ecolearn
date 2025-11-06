<?php
namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    public function run()
    {
        $lessons = [
            // Your lesson data here (same as before)
        ];

        foreach ($lessons as $lesson) {
            Lesson::firstOrCreate(
                ['title' => $lesson['title']],
                $lesson
            );
        }

        $this->command->info('Lessons seeded successfully!');
    }
}
