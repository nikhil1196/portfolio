<?php
return array (
  'Exercise' => 
  array (
    0 => 
    array (
      'name' => 'Barbell Squat',
      'muscle_group' => 'Legs',
      'equipment' => 'Barbell',
      'difficulty' => 'Intermediate',
      'video_url' => 'https://www.youtube.com/watch?v=ultWZbUMPL8',
      'description' => 'Feet shoulder-width, brace core, descend until thighs parallel.',
    ),
    1 => 
    array (
      'name' => 'Push-Up',
      'muscle_group' => 'Chest',
      'equipment' => 'Bodyweight',
      'difficulty' => 'Beginner',
      'video_url' => 'https://www.youtube.com/watch?v=IODxDxX7oi4',
      'description' => 'Hands under shoulders, body straight, full range of motion.',
    ),
    2 => 
    array (
      'name' => 'Deadlift',
      'muscle_group' => 'Back',
      'equipment' => 'Barbell',
      'difficulty' => 'Advanced',
      'video_url' => 'https://www.youtube.com/watch?v=op9kVnSso6Q',
      'description' => 'Hinge at hips, neutral spine, drive through heels.',
    ),
    3 => 
    array (
      'name' => 'Dumbbell Shoulder Press',
      'muscle_group' => 'Shoulders',
      'equipment' => 'Dumbbells',
      'difficulty' => 'Beginner',
      'video_url' => 'https://www.youtube.com/watch?v=qEwKCR5JCog',
      'description' => 'Press overhead without arching lower back.',
    ),
    4 => 
    array (
      'name' => 'Plank',
      'muscle_group' => 'Core',
      'equipment' => 'Bodyweight',
      'difficulty' => 'Beginner',
      'video_url' => 'https://www.youtube.com/watch?v=pSHjTRCQxIw',
      'description' => 'Hold straight line from head to heels, 30-60s.',
    ),
  ),
  'WorkoutPlan' => 
  array (
    0 => 
    array (
      'name' => 'Beginner Full Body',
      'goal' => 'General Fitness',
      'level' => 'Beginner',
      'duration_weeks' => 8,
      'description' => '3-day full body routine for new members.',
    ),
    1 => 
    array (
      'name' => 'Muscle Builder 5x5',
      'goal' => 'Muscle Gain',
      'level' => 'Intermediate',
      'duration_weeks' => 12,
      'description' => 'Progressive overload compound lifts.',
    ),
    2 => 
    array (
      'name' => 'Fat Burn Circuit',
      'goal' => 'Weight Loss',
      'level' => 'Beginner',
      'duration_weeks' => 6,
      'description' => 'HIIT + resistance circuits.',
    ),
  ),
  'WorkoutItem' => 
  array (
    0 => 
    array (
      'workout_plan_id' => 1,
      'exercise_id' => 1,
      'day' => 'Day 1',
      'sets' => 3,
      'reps' => 12,
    ),
    1 => 
    array (
      'workout_plan_id' => 1,
      'exercise_id' => 2,
      'day' => 'Day 1',
      'sets' => 3,
      'reps' => 15,
    ),
    2 => 
    array (
      'workout_plan_id' => 1,
      'exercise_id' => 5,
      'day' => 'Day 1',
      'sets' => 3,
      'reps' => 60,
    ),
    3 => 
    array (
      'workout_plan_id' => 2,
      'exercise_id' => 3,
      'day' => 'Day 1',
      'sets' => 5,
      'reps' => 5,
    ),
    4 => 
    array (
      'workout_plan_id' => 2,
      'exercise_id' => 1,
      'day' => 'Day 2',
      'sets' => 5,
      'reps' => 5,
    ),
  ),
  'MemberWorkout' => 
  array (
    0 => 
    array (
      'member_id' => 1,
      'workout_plan_id' => 1,
      'start_date' => '2026-11-01',
      'status' => 'Active',
    ),
    1 => 
    array (
      'member_id' => 2,
      'workout_plan_id' => 3,
      'start_date' => '2026-11-10',
      'status' => 'Active',
    ),
    2 => 
    array (
      'member_id' => 3,
      'workout_plan_id' => 2,
      'start_date' => '2026-10-15',
      'status' => 'Paused',
    ),
  ),
  'Measurement' => 
  array (
    0 => 
    array (
      'member_id' => 1,
      'measured_on' => '2026-10-01',
      'weight_kg' => 82.5,
      'height_cm' => 175,
      'chest_cm' => 102,
      'waist_cm' => 88,
      'arms_cm' => 34,
      'body_fat' => 21.5,
      'notes' => 'Baseline',
    ),
    1 => 
    array (
      'member_id' => 1,
      'measured_on' => '2026-11-01',
      'weight_kg' => 80.1,
      'height_cm' => 175,
      'chest_cm' => 103,
      'waist_cm' => 85,
      'arms_cm' => 35,
      'body_fat' => 19.8,
      'notes' => 'Good progress',
    ),
    2 => 
    array (
      'member_id' => 2,
      'measured_on' => '2026-11-05',
      'weight_kg' => 64.0,
      'height_cm' => 162,
      'chest_cm' => 90,
      'waist_cm' => 72,
      'arms_cm' => 28,
      'body_fat' => 24.1,
      'notes' => NULL,
    ),
  ),
  'PtSession' => 
  array (
    0 => 
    array (
      'member_id' => 1,
      'trainer_id' => 1,
      'session_date' => '2026-11-20',
      'start_time' => '07:00',
      'duration_min' => 60,
      'focus' => 'Squat form correction',
      'status' => 'Scheduled',
    ),
    1 => 
    array (
      'member_id' => 2,
      'trainer_id' => 2,
      'session_date' => '2026-11-18',
      'start_time' => '18:30',
      'duration_min' => 45,
      'focus' => 'Core conditioning',
      'status' => 'Completed',
    ),
  ),
  'GymClass' => 
  array (
    0 => 
    array (
      'name' => 'Morning Yoga',
      'trainer_id' => 2,
      'day' => 'Monday',
      'start_time' => '06:30',
      'duration_min' => 60,
      'capacity' => 20,
      'status' => 'Active',
    ),
    1 => 
    array (
      'name' => 'Zumba',
      'trainer_id' => 2,
      'day' => 'Wednesday',
      'start_time' => '19:00',
      'duration_min' => 45,
      'capacity' => 30,
      'status' => 'Active',
    ),
    2 => 
    array (
      'name' => 'Strength Circuit',
      'trainer_id' => 1,
      'day' => 'Friday',
      'start_time' => '18:00',
      'duration_min' => 60,
      'capacity' => 15,
      'status' => 'Active',
    ),
  ),
  'ClassBooking' => 
  array (
    0 => 
    array (
      'gym_class_id' => 1,
      'member_id' => 1,
      'booking_date' => '2026-11-24',
      'status' => 'Booked',
    ),
    1 => 
    array (
      'gym_class_id' => 2,
      'member_id' => 2,
      'booking_date' => '2026-11-26',
      'status' => 'Booked',
    ),
    2 => 
    array (
      'gym_class_id' => 3,
      'member_id' => 3,
      'booking_date' => '2026-11-21',
      'status' => 'Attended',
    ),
  ),
);
