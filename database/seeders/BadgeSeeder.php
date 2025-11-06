<?php
// database/seeders/BadgeSeeder.php
namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run()
    {
        $badges = [
            [
                'name' => 'Eco Beginner',
                'description' => 'Earned 100 eco points',
                'image_url' => '/images/badges/beginner.png',
                'criteria_type' => 'points',
                'criteria_value' => 100,
            ],
            [
                'name' => 'Climate Champion',
                'description' => 'Complete 5 climate change quizzes',
                'image_url' => '/images/badges/climate-champion.png',
                'criteria_type' => 'quizzes',
                'criteria_value' => 5,
            ],
            [
                'name' => 'Waste Warrior',
                'description' => 'Complete all waste management challenges',
                'image_url' => '/images/badges/waste-warrior.png',
                'criteria_type' => 'challenges',
                'criteria_value' => 3,
            ],
            [
                'name' => 'Conservation Expert',
                'description' => 'Reach level 5',
                'image_url' => '/images/badges/conservation-expert.png',
                'criteria_type' => 'points',
                'criteria_value' => 500,
            ],
            [
                'name' => 'Perfect Score',
                'description' => 'Get 100% on any quiz',
                'image_url' => '/images/badges/perfect-score.png',
                'criteria_type' => 'special',
                'criteria_value' => 1,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }

        $this->command->info('Badges seeded successfully!');
    }
}
