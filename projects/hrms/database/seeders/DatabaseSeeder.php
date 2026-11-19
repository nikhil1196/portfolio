<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Role::insert([
            ['name' => 'Admin', 'perms' => '*', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manager', 'perms' => 'departments,employees,attendance,leaves,payroll', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Viewer', 'perms' => '', 'created_at' => now(), 'updated_at' => now()],
        ]);
        \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@demo.local', 'password' => \Illuminate\Support\Facades\Hash::make('admin123')]);
        \App\Models\User::where('email', 'admin@demo.local')->update(['role_id' => 1]);
        \App\Models\Department::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'Engineering',
    'head' => 'Nikhil Agrawal',
    'status' => 'Active',
  ),
  1 => 
  array (
    'name' => 'HR',
    'head' => 'Priya Sharma',
    'status' => 'Active',
  ),
  2 => 
  array (
    'name' => 'Sales',
    'head' => 'Amit Deshmukh',
    'status' => 'Active',
  ),
  3 => 
  array (
    'name' => 'Finance',
    'head' => 'Ritu Kapoor',
    'status' => 'Active',
  ),
)));
        \App\Models\Employee::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'emp_code' => 'EMP-001',
    'name' => 'Nikhil Agrawal',
    'dept_id' => 1,
    'designation' => 'Technical Lead',
    'email' => 'nikhil@example.com',
    'phone' => '9830001001',
    'joining_date' => '2023-01-02',
    'salary' => 120000,
    'status' => 'Active',
  ),
  1 => 
  array (
    'emp_code' => 'EMP-002',
    'name' => 'Priya Sharma',
    'dept_id' => 2,
    'designation' => 'HR Manager',
    'email' => 'priya@example.com',
    'phone' => '9830001002',
    'joining_date' => '2021-06-15',
    'salary' => 75000,
    'status' => 'Active',
  ),
  2 => 
  array (
    'emp_code' => 'EMP-003',
    'name' => 'Amit Deshmukh',
    'dept_id' => 3,
    'designation' => 'Sales Executive',
    'email' => 'amit.d@example.com',
    'phone' => '9830001003',
    'joining_date' => '2022-03-10',
    'salary' => 55000,
    'status' => 'Active',
  ),
  3 => 
  array (
    'emp_code' => 'EMP-004',
    'name' => 'Ritu Kapoor',
    'dept_id' => 4,
    'designation' => 'Accountant',
    'email' => 'ritu@example.com',
    'phone' => '9830001004',
    'joining_date' => '2020-11-01',
    'salary' => 60000,
    'status' => 'Active',
  ),
  4 => 
  array (
    'emp_code' => 'EMP-005',
    'name' => 'Vikas Yadav',
    'dept_id' => 1,
    'designation' => 'Backend Developer',
    'email' => 'vikas@example.com',
    'phone' => '9830001005',
    'joining_date' => '2024-02-19',
    'salary' => 65000,
    'status' => 'Active',
  ),
)));
        \App\Models\HrAttendance::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'emp_id' => 1,
    'work_date' => '2026-11-19',
    'check_in' => '09:15',
    'status' => 'Present',
  ),
  1 => 
  array (
    'emp_id' => 2,
    'work_date' => '2026-11-19',
    'check_in' => '09:30',
    'status' => 'Present',
  ),
  2 => 
  array (
    'emp_id' => 3,
    'work_date' => '2026-11-19',
    'check_in' => NULL,
    'status' => 'Leave',
  ),
  3 => 
  array (
    'emp_id' => 4,
    'work_date' => '2026-11-19',
    'check_in' => '09:05',
    'status' => 'Present',
  ),
)));
        \App\Models\Leave::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'emp_id' => 3,
    'type' => 'Casual',
    'from_date' => '2026-11-19',
    'to_date' => '2026-11-20',
    'reason' => 'Family function',
    'status' => 'Approved',
  ),
  1 => 
  array (
    'emp_id' => 5,
    'type' => 'Sick',
    'from_date' => '2026-11-24',
    'to_date' => '2026-11-25',
    'reason' => 'Doctor advised rest',
    'status' => 'Pending',
  ),
)));
        \App\Models\Payroll::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'emp_id' => 1,
    'month' => '2026-10',
    'basic' => 120000,
    'allowances' => 18000,
    'deductions' => 5000,
    'net' => 133000,
    'status' => 'Paid',
  ),
  1 => 
  array (
    'emp_id' => 2,
    'month' => '2026-10',
    'basic' => 75000,
    'allowances' => 10000,
    'deductions' => 3000,
    'net' => 82000,
    'status' => 'Paid',
  ),
)));
    }
}
