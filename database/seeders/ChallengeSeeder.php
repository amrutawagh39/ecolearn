<?php
// database/seeders/ChallengeSeeder.php
namespace Database\Seeders;

use App\Models\Challenge;
use Illuminate\Database\Seeder;

class ChallengeSeeder extends Seeder
{
    public function run()
    {
        $challenges = [
            [
                'title' => 'Plant a Tree',
                'description' => 'Contribute to greening the environment by planting a tree',
                'challenge_type' => 'monthly',
                'task_description' => 'Plant a native tree species and document its growth with photos',
                'points_reward' => 100,
                'duration_days' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
            ],
            [
                'title' => 'Plastic-Free Day',
                'description' => 'Spend one day without using any single-use plastic',
                'challenge_type' => 'daily',
                'task_description' => 'Avoid all single-use plastic items for 24 hours and document your experience',
                'points_reward' => 50,
                'duration_days' => 1,
                'image_url' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
            ],
            [
                'title' => 'Water Conservation Week',
                'description' => 'Implement water-saving practices for one week',
                'challenge_type' => 'weekly',
                'task_description' => 'Use water-saving techniques like bucket baths, turning off taps, fixing leaks for 7 days',
                'points_reward' => 75,
                'duration_days' => 7,
                'image_url' => 'https://images.unsplash.com/photo-1551085254-e96b210db58a?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
            ],
            [
                'title' => 'Energy Audit',
                'description' => 'Conduct a home energy audit and suggest improvements',
                'challenge_type' => 'special',
                'task_description' => 'Check your home for energy wastage and implement at least 2 improvements',
                'points_reward' => 150,
                'duration_days' => 14,
                'image_url' => 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
            ],
        ];

        foreach ($challenges as $challenge) {
            Challenge::create($challenge);
        }

        $this->command->info('Challenges seeded successfully!');
    }
}
