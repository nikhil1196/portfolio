<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Role::insert([
            ['name' => 'Admin', 'perms' => '*', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manager', 'perms' => 'patients,doctors,appointments,prescriptions,bills', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Viewer', 'perms' => '', 'created_at' => now(), 'updated_at' => now()],
        ]);
        \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@demo.local', 'password' => \Illuminate\Support\Facades\Hash::make('admin123')]);
        \App\Models\User::where('email', 'admin@demo.local')->update(['role_id' => 1]);
        \App\Models\Doctor::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'Dr. Anita Shah',
    'specialty' => 'General Medicine',
    'phone' => '9865001101',
    'fee' => 500,
    'status' => 'Active',
  ),
  1 => 
  array (
    'name' => 'Dr. Rajesh Patel',
    'specialty' => 'Orthopedics',
    'phone' => '9865001102',
    'fee' => 800,
    'status' => 'Active',
  ),
  2 => 
  array (
    'name' => 'Dr. Kavita Desai',
    'specialty' => 'Pediatrics',
    'phone' => '9865001103',
    'fee' => 600,
    'status' => 'Active',
  ),
  3 => 
  array (
    'name' => 'Dr. Manoj Trivedi',
    'specialty' => 'Dermatology',
    'phone' => '9865001104',
    'fee' => 700,
    'status' => 'Active',
  ),
)));
        \App\Models\Patient::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'Suresh Kumar',
    'phone' => '9876100001',
    'dob' => '1985-04-12',
    'gender' => 'Male',
    'blood' => 'B+',
    'address' => 'Vadodara',
    'status' => 'Active',
  ),
  1 => 
  array (
    'name' => 'Nisha Gandhi',
    'phone' => '9876100002',
    'dob' => '1992-08-23',
    'gender' => 'Female',
    'blood' => 'O+',
    'address' => 'Ahmedabad',
    'status' => 'Active',
  ),
  2 => 
  array (
    'name' => 'Farhan Sheikh',
    'phone' => '9876100003',
    'dob' => '1978-01-30',
    'gender' => 'Male',
    'blood' => 'AB+',
    'address' => 'Vadodara',
    'status' => 'Active',
  ),
  3 => 
  array (
    'name' => 'Ritu Malhotra',
    'phone' => '9876100004',
    'dob' => '2000-11-05',
    'gender' => 'Female',
    'blood' => 'A+',
    'address' => 'Surat',
    'status' => 'Active',
  ),
)));
        \App\Models\Appointment::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'patient_id' => 1,
    'doctor_id' => 1,
    'appt_date' => '2026-11-19',
    'appt_time' => '10:30',
    'reason' => 'Fever & cold',
    'status' => 'Scheduled',
  ),
  1 => 
  array (
    'patient_id' => 2,
    'doctor_id' => 4,
    'appt_date' => '2026-11-19',
    'appt_time' => '11:15',
    'reason' => 'Skin rash',
    'status' => 'Scheduled',
  ),
  2 => 
  array (
    'patient_id' => 3,
    'doctor_id' => 2,
    'appt_date' => '2026-11-20',
    'appt_time' => '09:45',
    'reason' => 'Knee pain',
    'status' => 'Scheduled',
  ),
)));
        \App\Models\Bill::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'invoice_no' => 'BILL-1001',
    'patient_id' => 1,
    'description' => 'Consultation',
    'amount' => 500,
    'status' => 'Paid',
    'paid_at' => '2026-11-19',
  ),
  1 => 
  array (
    'invoice_no' => 'BILL-1002',
    'patient_id' => 2,
    'description' => 'Consultation + Test',
    'amount' => 1500,
    'status' => 'Pending',
    'paid_at' => '2026-11-19',
  ),
)));
    }
}
