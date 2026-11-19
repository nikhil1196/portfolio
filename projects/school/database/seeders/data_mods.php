<?php
return array (
  'Subject' => 
  array (
    0 => 
    array (
      'name' => 'Mathematics',
      'code' => 'MATH',
      'class_id' => 1,
      'teacher_id' => 1,
      'status' => 'Active',
    ),
    1 => 
    array (
      'name' => 'Science',
      'code' => 'SCI',
      'class_id' => 1,
      'teacher_id' => 2,
      'status' => 'Active',
    ),
    2 => 
    array (
      'name' => 'English',
      'code' => 'ENG',
      'class_id' => 2,
      'teacher_id' => 3,
      'status' => 'Active',
    ),
  ),
  'Staff' => 
  array (
    0 => 
    array (
      'name' => 'Ramesh Yadav',
      'role' => 'Accountant',
      'dept' => 'Accounts',
      'phone' => '9811111111',
      'email' => 'ramesh@school.demo',
      'joined' => '2020-06-01',
      'status' => 'Active',
    ),
    1 => 
    array (
      'name' => 'Sunita Verma',
      'role' => 'Librarian',
      'dept' => 'Library',
      'phone' => '9811111112',
      'email' => 'sunita@school.demo',
      'joined' => '2021-04-15',
      'status' => 'Active',
    ),
  ),
  'Timetable' => 
  array (
    0 => 
    array (
      'class_id' => 1,
      'day' => 'Monday',
      'period' => 1,
      'subject_id' => 1,
      'teacher_id' => 1,
      'start_time' => '09:00',
      'end_time' => '09:45',
    ),
    1 => 
    array (
      'class_id' => 1,
      'day' => 'Monday',
      'period' => 2,
      'subject_id' => 2,
      'teacher_id' => 2,
      'start_time' => '09:45',
      'end_time' => '10:30',
    ),
    2 => 
    array (
      'class_id' => 2,
      'day' => 'Tuesday',
      'period' => 1,
      'subject_id' => 3,
      'teacher_id' => 3,
      'start_time' => '09:00',
      'end_time' => '09:45',
    ),
  ),
  'Material' => 
  array (
    0 => 
    array (
      'title' => 'Algebra Notes Ch.1',
      'subject_id' => 1,
      'class_id' => 1,
      'type' => 'PDF',
      'url' => 'materials/algebra-ch1.pdf',
      'status' => 'Active',
    ),
    1 => 
    array (
      'title' => 'Photosynthesis Video',
      'subject_id' => 2,
      'class_id' => 1,
      'type' => 'Video',
      'url' => 'https://demo.local/photo-video',
      'status' => 'Active',
    ),
  ),
  'Assignment' => 
  array (
    0 => 
    array (
      'title' => 'Quadratic Equations HW',
      'subject_id' => 1,
      'class_id' => 1,
      'teacher_id' => 1,
      'due_date' => '2026-12-10',
      'description' => 'Solve exercises 1–10',
      'status' => 'Open',
    ),
    1 => 
    array (
      'title' => 'Essay: My City',
      'subject_id' => 3,
      'class_id' => 2,
      'teacher_id' => 3,
      'due_date' => '2026-12-15',
      'description' => '500 words',
      'status' => 'Open',
    ),
  ),
  'Submission' => 
  array (
    0 => 
    array (
      'assignment_id' => 1,
      'student_id' => 1,
      'submitted_at' => '2026-11-20 10:00',
      'notes' => 'All done',
      'marks' => 9,
      'status' => 'Graded',
    ),
  ),
  'Exam' => 
  array (
    0 => 
    array (
      'name' => 'Midterm',
      'class_id' => 1,
      'subject_id' => 1,
      'exam_date' => '2026-12-20',
      'max_marks' => 100,
      'status' => 'Scheduled',
    ),
    1 => 
    array (
      'name' => 'Midterm',
      'class_id' => 1,
      'subject_id' => 2,
      'exam_date' => '2026-12-21',
      'max_marks' => 100,
      'status' => 'Scheduled',
    ),
  ),
);
