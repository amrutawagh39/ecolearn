-- ecolearn_data.sql
-- Sample data insertion only

USE ecolearn;

-- Insert sample users
INSERT INTO users (name, email, password, role, school_name, grade_level, eco_points, level) VALUES
('Rahul Sharma', 'rahul@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'Delhi Public School', 'Grade 10', 150, 2),
('Priya Patel', 'priya@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'Kendriya Vidyalaya', 'Grade 12', 320, 4),
('Dr. Amit Kumar', 'amit@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', 'St. Xavier College', 'Professor', 0, 1),
('Admin User', 'admin@ecolearn.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'EcoLearn Platform', 'Administrator', 0, 1);

-- Insert sample lessons
INSERT INTO lessons (title, description, content, category, difficulty_level, duration_minutes, image_url) VALUES
('Understanding Climate Change', 'Learn about the causes and effects of climate change and what we can do to mitigate it.', '<h3>What is Climate Change?</h3><p>Climate change refers to long-term shifts in temperatures and weather patterns...</p>', 'climate_change', 'beginner', 15, 'https://images.unsplash.com/photo-1615751072497-5f5169febe17?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60'),
('Waste Segregation Basics', 'Learn how to properly segregate waste and understand recycling processes.', '<h3>Why Waste Segregation Matters</h3><p>Proper waste segregation helps in efficient recycling...</p>', 'waste_management', 'beginner', 12, 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60'),
('Biodiversity Conservation', 'Understand the importance of biodiversity and how to protect it.', '<h3>What is Biodiversity?</h3><p>Biodiversity refers to the variety of life on Earth...</p>', 'biodiversity', 'intermediate', 20, 'https://images.unsplash.com/photo-1418065460487-3e41a6c84dc5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60'),
('Water Conservation Methods', 'Learn practical ways to conserve water in daily life.', '<h3>Importance of Water Conservation</h3><p>Water is a precious resource that needs to be conserved...</p>', 'water_conservation', 'beginner', 10, 'https://images.unsplash.com/photo-1439066615861-d1af74d74000?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60'),
('Renewable Energy Sources', 'Explore different types of renewable energy and their benefits.', '<h3>Types of Renewable Energy</h3><ul><li><strong>Solar Energy:</strong> From the sun</li><li><strong>Wind Energy:</strong> From wind turbines</li></ul>', 'energy', 'intermediate', 18, 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');

-- Insert sample quizzes
INSERT INTO quizzes (lesson_id, title, description, questions_count, time_limit_minutes, passing_score) VALUES
(1, 'Climate Change Basics Quiz', 'Test your knowledge about climate change fundamentals', 5, 10, 60),
(2, 'Waste Management Quiz', 'Check your understanding of waste segregation and recycling', 5, 10, 70),
(3, 'Biodiversity Assessment', 'Evaluate your knowledge about biodiversity conservation', 6, 12, 65),
(NULL, 'Environmental Awareness Test', 'General environmental knowledge quiz', 8, 15, 60);

-- Insert sample questions
INSERT INTO questions (quiz_id, question_text, question_type, options, correct_answer, points, explanation) VALUES
(1, 'What is the main cause of current climate change?', 'multiple_choice', '[\"Natural climate cycles\", \"Human activities\", \"Volcanic eruptions\", \"Solar fluctuations\"]', 'Human activities', 10, 'Human activities, especially burning fossil fuels, are the primary driver of current climate change.'),
(1, 'Climate change only affects temperature, not weather patterns.', 'true_false', '[\"True\", \"False\"]', 'False', 10, 'Climate change affects both temperature and weather patterns, including rainfall, storms, and seasons.'),
(1, 'Name one greenhouse gas that contributes to climate change.', 'short_answer', NULL, 'carbon dioxide,co2,methane,nitrous oxide', 10, 'Common greenhouse gases include carbon dioxide (CO2), methane (CH4), and nitrous oxide (N2O).'),
(2, 'Which of these items should go in the recycling bin?', 'multiple_choice', '[\"Food waste\", \"Plastic bottles\", \"Batteries\", \"Medical waste\"]', 'Plastic bottles', 10, 'Plastic bottles are recyclable, while the others require special disposal methods.'),
(2, 'All types of plastic can be recycled.', 'true_false', '[\"True\", \"False\"]', 'False', 10, 'Not all plastics are recyclable. Check local recycling guidelines for acceptable materials.');

-- Insert sample challenges
INSERT INTO challenges (title, description, challenge_type, task_description, points_reward, duration_days, image_url) VALUES
('Plant a Tree', 'Contribute to greening the environment by planting a tree', 'monthly', 'Plant a native tree species and document its growth with photos', 100, 30, 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60'),
('Plastic-Free Day', 'Spend one day without using any single-use plastic', 'daily', 'Avoid all single-use plastic items for 24 hours and document your experience', 50, 1, 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60'),
('Water Conservation Week', 'Implement water-saving practices for one week', 'weekly', 'Use water-saving techniques like bucket baths, turning off taps, fixing leaks for 7 days', 75, 7, 'https://images.unsplash.com/photo-1551085254-e96b210db58a?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60'),
('Energy Audit', 'Conduct a home energy audit and suggest improvements', 'special', 'Check your home for energy wastage and implement at least 2 improvements', 150, 14, 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');

-- Insert sample badges
INSERT INTO badges (name, description, image_url, criteria_type, criteria_value) VALUES
('Eco Beginner', 'Earned 100 eco points', '/images/badges/beginner.png', 'points', 100),
('Climate Champion', 'Complete 5 climate change quizzes', '/images/badges/climate-champion.png', 'quizzes', 5),
('Waste Warrior', 'Complete all waste management challenges', '/images/badges/waste-warrior.png', 'challenges', 3),
('Conservation Expert', 'Reach level 5', '/images/badges/conservation-expert.png', 'points', 500),
('Perfect Score', 'Get 100% on any quiz', '/images/badges/perfect-score.png', 'special', 1);
