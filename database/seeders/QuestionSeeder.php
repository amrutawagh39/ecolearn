<?php
// database/seeders/QuestionSeeder.php
namespace Database\Seeders;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            // Quiz 1 - Climate Change Basics Quiz (3 questions)
            [
                'quiz_id' => 1,
                'question_text' => 'What is the main cause of current climate change?',
                'question_type' => 'multiple_choice',
                'options' => json_encode(['Natural climate cycles', 'Human activities', 'Volcanic eruptions', 'Solar fluctuations']),
                'correct_answer' => 'Human activities',
                'points' => 10,
                'explanation' => 'Human activities, especially burning fossil fuels, are the primary driver of current climate change.',
                'is_active' => true,
            ],
            [
                'quiz_id' => 1,
                'question_text' => 'Climate change only affects temperature, not weather patterns.',
                'question_type' => 'true_false',
                'options' => json_encode(['True', 'False']),
                'correct_answer' => 'False',
                'points' => 10,
                'explanation' => 'Climate change affects both temperature and weather patterns, including rainfall, storms, and seasons.',
                'is_active' => true,
            ],
            [
                'quiz_id' => 1,
                'question_text' => 'Name one greenhouse gas that contributes to climate change.',
                'question_type' => 'short_answer',
                'options' => null,
                'correct_answer' => 'carbon dioxide,co2,methane,nitrous oxide',
                'points' => 10,
                'explanation' => 'Common greenhouse gases include carbon dioxide (CO2), methane (CH4), and nitrous oxide (N2O).',
                'is_active' => true,
            ],

            // Quiz 2 - Waste Management Quiz (2 questions)
            [
                'quiz_id' => 2,
                'question_text' => 'Which of these items should go in the recycling bin?',
                'question_type' => 'multiple_choice',
                'options' => json_encode(['Food waste', 'Plastic bottles', 'Batteries', 'Medical waste']),
                'correct_answer' => 'Plastic bottles',
                'points' => 10,
                'explanation' => 'Plastic bottles are recyclable, while the others require special disposal methods.',
                'is_active' => true,
            ],
            [
                'quiz_id' => 2,
                'question_text' => 'All types of plastic can be recycled.',
                'question_type' => 'true_false',
                'options' => json_encode(['True', 'False']),
                'correct_answer' => 'False',
                'points' => 10,
                'explanation' => 'Not all plastics are recyclable. Check local recycling guidelines for acceptable materials.',
                'is_active' => true,
            ],

            // Quiz 3 - Biodiversity Assessment (6 questions)
            [
                'quiz_id' => 3,
                'question_text' => 'What does biodiversity refer to?',
                'question_type' => 'multiple_choice',
                'options' => json_encode(['Only animal species', 'Only plant species', 'Variety of all life forms', 'Only endangered species']),
                'correct_answer' => 'Variety of all life forms',
                'points' => 10,
                'explanation' => 'Biodiversity includes all living organisms - plants, animals, microorganisms, and their ecosystems.',
                'is_active' => true,
            ],
            [
                'quiz_id' => 3,
                'question_text' => 'Which of these is a major threat to biodiversity?',
                'question_type' => 'multiple_choice',
                'options' => json_encode(['Habitat destruction', 'Climate change', 'Pollution', 'All of the above']),
                'correct_answer' => 'All of the above',
                'points' => 10,
                'explanation' => 'Habitat destruction, climate change, and pollution are all significant threats to biodiversity.',
                'is_active' => true,
            ],
            [
                'quiz_id' => 3,
                'question_text' => 'True or False: Biodiversity is only important in rainforests and coral reefs.',
                'question_type' => 'true_false',
                'options' => json_encode(['True', 'False']),
                'correct_answer' => 'False',
                'points' => 10,
                'explanation' => 'Biodiversity is important in all ecosystems, including deserts, grasslands, and urban areas.',
                'is_active' => true,
            ],
            [
                'quiz_id' => 3,
                'question_text' => 'What is an endemic species?',
                'question_type' => 'multiple_choice',
                'options' => json_encode(['A species found worldwide', 'A species found only in one specific area', 'An extinct species', 'A domesticated species']),
                'correct_answer' => 'A species found only in one specific area',
                'points' => 10,
                'explanation' => 'Endemic species are native to and restricted to a particular geographical area.',
                'is_active' => true,
            ],
            [
                'quiz_id' => 3,
                'question_text' => 'Name one benefit of biodiversity to humans.',
                'question_type' => 'short_answer',
                'options' => null,
                'correct_answer' => 'medicine,food,clean air,clean water,climate regulation,pollination,soil fertility',
                'points' => 10,
                'explanation' => 'Biodiversity provides medicines, food, clean air and water, climate regulation, pollination, and soil fertility.',
                'is_active' => true,
            ],
            [
                'quiz_id' => 3,
                'question_text' => 'What percentage of species on Earth are estimated to have gone extinct due to human activities?',
                'question_type' => 'multiple_choice',
                'options' => json_encode(['1-5%', '10-15%', '25-30%', 'Over 50%']),
                'correct_answer' => '25-30%',
                'points' => 15,
                'explanation' => 'Scientists estimate that 25-30% of species have gone extinct due to human activities, with current extinction rates 100-1000 times higher than natural rates.',
                'is_active' => true,
            ],

            // Quiz 4 - Environmental Awareness Test (5 questions)
            [
                'quiz_id' => 4,
                'question_text' => 'Which of these is a renewable energy source?',
                'question_type' => 'multiple_choice',
                'options' => json_encode(['Coal', 'Natural Gas', 'Solar Power', 'Nuclear Power']),
                'correct_answer' => 'Solar Power',
                'points' => 10,
                'explanation' => 'Solar power is renewable and sustainable, unlike fossil fuels.',
                'is_active' => true,
            ],
            [
                'quiz_id' => 4,
                'question_text' => 'What is the main purpose of the 3Rs (Reduce, Reuse, Recycle)?',
                'question_type' => 'multiple_choice',
                'options' => json_encode(['To save money', 'To reduce waste and conserve resources', 'To create more jobs', 'To increase manufacturing']),
                'correct_answer' => 'To reduce waste and conserve resources',
                'points' => 10,
                'explanation' => 'The 3Rs help minimize waste generation and conserve natural resources.',
                'is_active' => true,
            ],
            [
                'quiz_id' => 4,
                'question_text' => 'True or False: Turning off lights when not in use has no significant impact on energy conservation.',
                'question_type' => 'true_false',
                'options' => json_encode(['True', 'False']),
                'correct_answer' => 'False',
                'points' => 10,
                'explanation' => 'Turning off lights when not needed significantly reduces electricity consumption and carbon emissions.',
                'is_active' => true,
            ],
            [
                'quiz_id' => 4,
                'question_text' => 'What is the primary cause of ocean acidification?',
                'question_type' => 'multiple_choice',
                'options' => json_encode(['Plastic pollution', 'Oil spills', 'Increased CO2 absorption', 'Sewage discharge']),
                'correct_answer' => 'Increased CO2 absorption',
                'points' => 10,
                'explanation' => 'Oceans absorb about 30% of CO2 emissions, which forms carbonic acid and lowers pH levels.',
                'is_active' => true,
            ],
            [
                'quiz_id' => 4,
                'question_text' => 'Name one way individuals can help protect the environment in their daily lives.',
                'question_type' => 'short_answer',
                'options' => null,
                'correct_answer' => 'reduce plastic use,conserve water,save energy,use public transport,plant trees,recycle,compost',
                'points' => 10,
                'explanation' => 'Individuals can make a difference by reducing plastic use, conserving water, saving energy, using public transport, planting trees, recycling, and composting.',
                'is_active' => true,
            ],
        ];

        foreach ($questions as $question) {
            Question::updateOrCreate(
                [
                    'quiz_id' => $question['quiz_id'],
                    'question_text' => $question['question_text']
                ],
                $question
            );
        }

        // Update questions_count for each quiz
        $quizzes = Quiz::all();
        foreach ($quizzes as $quiz) {
            $actualCount = $quiz->questions()->where('is_active', true)->count();
            $quiz->update(['questions_count' => $actualCount]);
        }

        $this->command->info('Questions seeded successfully! Total questions: ' . Question::count());
    }
}
