<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Role::insert([
            ['name' => 'Admin', 'perms' => '*', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manager', 'perms' => 'patients,doctors,appointments,prescriptions,bills,clinics,schedules,payments', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Viewer', 'perms' => '', 'created_at' => now(), 'updated_at' => now()],
        ]);
        \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@demo.local', 'password' => \Illuminate\Support\Facades\Hash::make('admin123')]);
        \App\Models\User::where('email', 'admin@demo.local')->update(['role_id' => 1]);
        \App\Models\Clinic::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'HealthFirst Multispeciality',
    'address' => '12 Ring Road',
    'city' => 'Vadodara',
    'phone' => '0265-2334455',
    'status' => 'Active',
  ),
  1 => 
  array (
    'name' => 'CarePlus Clinic',
    'address' => '88 Alkapuri Arcade',
    'city' => 'Vadodara',
    'phone' => '0265-2445566',
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
        \App\Models\Doctor::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'Dr. Anita Shah',
    'specialty' => 'General Medicine',
    'phone' => '9865001101',
    'fee' => 500,
    'status' => 'Active',
    'email' => 'anita.shah@clinic.demo',
    'clinic_id' => 1,
  ),
  1 => 
  array (
    'name' => 'Dr. Rajesh Patel',
    'specialty' => 'Orthopedics',
    'phone' => '9865001102',
    'fee' => 800,
    'status' => 'Active',
    'email' => 'rajesh.patel@clinic.demo',
    'clinic_id' => 2,
  ),
  2 => 
  array (
    'name' => 'Dr. Kavita Desai',
    'specialty' => 'Pediatrics',
    'phone' => '9865001103',
    'fee' => 600,
    'status' => 'Active',
    'email' => 'kavita.desai@clinic.demo',
    'clinic_id' => 1,
  ),
  3 => 
  array (
    'name' => 'Dr. Manoj Trivedi',
    'specialty' => 'Dermatology',
    'phone' => '9865001104',
    'fee' => 700,
    'status' => 'Active',
    'email' => 'manoj.trivedi@clinic.demo',
    'clinic_id' => 2,
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
    'clinic_id' => 1,
  ),
  1 => 
  array (
    'patient_id' => 2,
    'doctor_id' => 4,
    'appt_date' => '2026-11-19',
    'appt_time' => '11:15',
    'reason' => 'Skin rash',
    'status' => 'Scheduled',
    'clinic_id' => 2,
  ),
  2 => 
  array (
    'patient_id' => 3,
    'doctor_id' => 2,
    'appt_date' => '2026-11-20',
    'appt_time' => '09:45',
    'reason' => 'Knee pain',
    'status' => 'Scheduled',
    'clinic_id' => 1,
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
        \App\Models\Schedule::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'doctor_id' => 1,
    'clinic_id' => 1,
    'day' => 'Monday',
    'start_time' => '09:00',
    'end_time' => '13:00',
    'slot_min' => 20,
    'status' => 'Active',
  ),
  1 => 
  array (
    'doctor_id' => 1,
    'clinic_id' => 1,
    'day' => 'Wednesday',
    'start_time' => '17:00',
    'end_time' => '20:00',
    'slot_min' => 20,
    'status' => 'Active',
  ),
  2 => 
  array (
    'doctor_id' => 2,
    'clinic_id' => 2,
    'day' => 'Tuesday',
    'start_time' => '10:00',
    'end_time' => '14:00',
    'slot_min' => 30,
    'status' => 'Active',
  ),
  3 => 
  array (
    'doctor_id' => 2,
    'clinic_id' => 2,
    'day' => 'Friday',
    'start_time' => '10:00',
    'end_time' => '14:00',
    'slot_min' => 30,
    'status' => 'Active',
  ),
)));
        \App\Models\Payment::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'appointment_id' => 1,
    'amount' => 500,
    'method' => 'Stripe',
    'status' => 'Paid',
    'receipt_no' => 'RCP-1001',
    'txn_ref' => 'txn_demo_8f3k2',
  ),
  1 => 
  array (
    'appointment_id' => 2,
    'amount' => 300,
    'method' => 'Cash',
    'status' => 'Paid',
    'receipt_no' => 'RCP-1002',
    'txn_ref' => NULL,
  ),
)));
    }
}
