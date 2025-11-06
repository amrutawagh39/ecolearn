<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            LessonSeeder::class,
            QuizSeeder::class,      // ← Should be QuizSeeder
            QuestionSeeder::class,  // ← Should be QuestionSeeder
            ChallengeSeeder::class,
            BadgeSeeder::class,
        ]);
    }
}
