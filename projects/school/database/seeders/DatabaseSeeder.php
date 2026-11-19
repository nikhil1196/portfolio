<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@demo.local', 'password' => \Illuminate\Support\Facades\Hash::make('admin123')]);
        \App\Models\Teacher::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'Sunita Rao',
    'subject' => 'Mathematics',
    'phone' => '9852001001',
    'qualification' => 'M.Sc, B.Ed',
    'status' => 'Active',
  ),
  1 => 
  array (
    'name' => 'Prakash Mehta',
    'subject' => 'Science',
    'phone' => '9852001002',
    'qualification' => 'M.Sc, B.Ed',
    'status' => 'Active',
  ),
  2 => 
  array (
    'name' => 'Rekha Pillai',
    'subject' => 'English',
    'phone' => '9852001003',
    'qualification' => 'M.A, B.Ed',
    'status' => 'Active',
  ),
  3 => 
  array (
    'name' => 'Imran Ansari',
    'subject' => 'Social Studies',
    'phone' => '9852001004',
    'qualification' => 'M.A, B.Ed',
    'status' => 'Active',
  ),
)));
        \App\Models\SchoolClass::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'Class 8',
    'section' => 'A',
    'teacher_id' => 1,
    'room' => 'R-201',
  ),
  1 => 
  array (
    'name' => 'Class 9',
    'section' => 'B',
    'teacher_id' => 2,
    'room' => 'R-305',
  ),
  2 => 
  array (
    'name' => 'Class 10',
    'section' => 'A',
    'teacher_id' => 3,
    'room' => 'R-104',
  ),
  3 => 
  array (
    'name' => 'Class 10',
    'section' => 'B',
    'teacher_id' => 4,
    'room' => 'R-105',
  ),
)));
        \App\Models\Student::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'Aarav Shah',
    'roll_no' => '10A-01',
    'class_id' => 3,
    'guardian' => 'Nilesh Shah',
    'phone' => '9862000011',
    'dob' => '2010-03-14',
    'status' => 'Active',
  ),
  1 => 
  array (
    'name' => 'Ishita Patel',
    'roll_no' => '10A-02',
    'class_id' => 3,
    'guardian' => 'Kiran Patel',
    'phone' => '9862000012',
    'dob' => '2010-07-22',
    'status' => 'Active',
  ),
  2 => 
  array (
    'name' => 'Rohan Gupta',
    'roll_no' => '9B-05',
    'class_id' => 2,
    'guardian' => 'Sanjay Gupta',
    'phone' => '9862000013',
    'dob' => '2011-01-09',
    'status' => 'Active',
  ),
  3 => 
  array (
    'name' => 'Zara Khan',
    'roll_no' => '8A-03',
    'class_id' => 1,
    'guardian' => 'Salim Khan',
    'phone' => '9862000014',
    'dob' => '2012-11-30',
    'status' => 'Active',
  ),
  4 => 
  array (
    'name' => 'Kabir Singh',
    'roll_no' => '10B-07',
    'class_id' => 4,
    'guardian' => 'Harjeet Singh',
    'phone' => '9862000015',
    'dob' => '2010-05-18',
    'status' => 'Active',
  ),
)));
        \App\Models\Fee::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'receipt_no' => 'RCP-2001',
    'student_id' => 1,
    'term' => 'Term 1',
    'amount' => 18000,
    'status' => 'Paid',
    'paid_at' => '2026-06-15',
  ),
  1 => 
  array (
    'receipt_no' => 'RCP-2002',
    'student_id' => 2,
    'term' => 'Term 1',
    'amount' => 18000,
    'status' => 'Paid',
    'paid_at' => '2026-06-18',
  ),
  2 => 
  array (
    'receipt_no' => 'RCP-2003',
    'student_id' => 4,
    'term' => 'Term 1',
    'amount' => 18000,
    'status' => 'Pending',
    'paid_at' => NULL,
  ),
)));
        \App\Models\Result::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'student_id' => 1,
    'exam' => 'Mid-Term',
    'subject' => 'Mathematics',
    'marks' => 88,
    'max_marks' => 100,
    'grade' => 'A',
  ),
  1 => 
  array (
    'student_id' => 2,
    'exam' => 'Mid-Term',
    'subject' => 'Mathematics',
    'marks' => 92,
    'max_marks' => 100,
    'grade' => 'A+',
  ),
  2 => 
  array (
    'student_id' => 3,
    'exam' => 'Mid-Term',
    'subject' => 'Science',
    'marks' => 65,
    'max_marks' => 100,
    'grade' => 'B',
  ),
)));
        \App\Models\Attendance::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'student_id' => 1,
    'att_date' => '2026-11-18',
    'status' => 'Present',
    'remark' => NULL,
  ),
  1 => 
  array (
    'student_id' => 2,
    'att_date' => '2026-11-18',
    'status' => 'Present',
    'remark' => NULL,
  ),
  2 => 
  array (
    'student_id' => 3,
    'att_date' => '2026-11-18',
    'status' => 'Absent',
    'remark' => 'Sick leave informed',
  ),
  3 => 
  array (
    'student_id' => 4,
    'att_date' => '2026-11-18',
    'status' => 'Late',
    'remark' => 'Arrived 9:40 AM',
  ),
  4 => 
  array (
    'student_id' => 5,
    'att_date' => '2026-11-18',
    'status' => 'Present',
    'remark' => NULL,
  ),
  5 => 
  array (
    'student_id' => 1,
    'att_date' => '2026-11-19',
    'status' => 'Present',
    'remark' => NULL,
  ),
  6 => 
  array (
    'student_id' => 2,
    'att_date' => '2026-11-19',
    'status' => 'Absent',
    'remark' => 'Family function',
  ),
)));
        \App\Models\Notice::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'title' => 'Diwali Vacation',
    'body' => 'School will remain closed from 24 Nov to 30 Nov for Diwali vacation. Classes resume 1 Dec.',
    'audience' => 'All',
    'publish_on' => '2026-11-15',
    'status' => 'Published',
  ),
  1 => 
  array (
    'title' => 'Parent-Teacher Meeting',
    'body' => 'PTM for Classes 8-10 on 28 Nov, 10 AM - 1 PM. Parents are requested to attend.',
    'audience' => 'Parents',
    'publish_on' => '2026-11-18',
    'status' => 'Published',
  ),
  2 => 
  array (
    'title' => 'Science Exhibition',
    'body' => 'Annual science exhibition on 5 Dec. Students must submit project entries by 30 Nov.',
    'audience' => 'Students',
    'publish_on' => '2026-11-19',
    'status' => 'Published',
  ),
)));
    }
}
