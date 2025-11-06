<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Rahul Sharma',
                'email' => 'rahul@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'school_name' => 'Delhi Public School',
                'grade_level' => 'Grade 10',
                'eco_points' => 150,
                'level' => 2,
            ],
            [
                'name' => 'Priya Patel',
                'email' => 'priya@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'school_name' => 'Kendriya Vidyalaya',
                'grade_level' => 'Grade 12',
                'eco_points' => 320,
                'level' => 4,
            ],
            [
                'name' => 'Dr. Amit Kumar',
                'email' => 'amit@example.com',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'school_name' => 'St. Xavier College',
                'grade_level' => 'Professor',
                'eco_points' => 0,
                'level' => 1,
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@ecolearn.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'school_name' => 'EcoLearn Platform',
                'grade_level' => 'Administrator',
                'eco_points' => 0,
                'level' => 1,
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        $this->command->info('Users seeded successfully!');
    }
}
