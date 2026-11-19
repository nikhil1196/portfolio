<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Role::insert([
            ['name' => 'Admin', 'perms' => '*', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manager', 'perms' => 'members,plans,trainers,payments', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Viewer', 'perms' => '', 'created_at' => now(), 'updated_at' => now()],
        ]);
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@demo.local',
            'password' => Hash::make('admin123'),
        ]);

        Plan::insert([
            ['name' => 'Monthly',     'duration_months' => 1,  'price' => 1500,  'features' => 'Gym floor access',               'status' => 'Active'],
            ['name' => 'Quarterly',   'duration_months' => 3,  'price' => 4000,  'features' => 'Gym + group classes',           'status' => 'Active'],
            ['name' => 'Half-Yearly', 'duration_months' => 6,  'price' => 7500,  'features' => 'Gym + classes + diet plan',     'status' => 'Active'],
            ['name' => 'Annual',      'duration_months' => 12, 'price' => 12000, 'features' => 'All access + personal session', 'status' => 'Active'],
        ]);

        Trainer::insert([
            ['name' => 'Rahul Verma', 'specialty' => 'Strength & Conditioning', 'phone' => '9876500011', 'status' => 'Active'],
            ['name' => 'Priya Nair',  'specialty' => 'Yoga & Mobility',         'phone' => '9876500012', 'status' => 'Active'],
            ['name' => 'Arjun Mehta', 'specialty' => 'CrossFit / HIIT',         'phone' => '9876500013', 'status' => 'Active'],
        ]);

        Member::insert([
            ['name' => 'Amit Sharma',    'email' => 'amit@example.com',   'phone' => '9876510001', 'plan_id' => 4, 'trainer_id' => 1,    'join_date' => '2026-01-10', 'status' => 'Active'],
            ['name' => 'Sneha Patel',    'email' => 'sneha@example.com',  'phone' => '9876510002', 'plan_id' => 2, 'trainer_id' => 2,    'join_date' => '2026-03-05', 'status' => 'Active'],
            ['name' => 'Vikram Singh',   'email' => 'vikram@example.com', 'phone' => '9876510003', 'plan_id' => 1, 'trainer_id' => 3,    'join_date' => '2026-10-01', 'status' => 'Active'],
            ['name' => 'Pooja Desai',    'email' => 'pooja@example.com',  'phone' => '9876510004', 'plan_id' => 3, 'trainer_id' => 1,    'join_date' => '2026-07-15', 'status' => 'Active'],
            ['name' => 'Karan Joshi',    'email' => 'karan@example.com',  'phone' => '9876510005', 'plan_id' => 1, 'trainer_id' => null, 'join_date' => '2026-11-02', 'status' => 'Active'],
            ['name' => 'Meera Iyer',     'email' => 'meera@example.com',  'phone' => '9876510006', 'plan_id' => 4, 'trainer_id' => 2,    'join_date' => '2025-12-20', 'status' => 'Active'],
            ['name' => 'Rohit Kulkarni', 'email' => 'rohit@example.com',  'phone' => '9876510007', 'plan_id' => 2, 'trainer_id' => 3,    'join_date' => '2026-09-11', 'status' => 'Inactive'],
            ['name' => 'Divya Rao',      'email' => 'divya@example.com',  'phone' => '9876510008', 'plan_id' => 1, 'trainer_id' => null, 'join_date' => '2026-11-10', 'status' => 'Active'],
        ]);

        Attendance::insert([
            ['member_id' => 1, 'check_in' => now()->subHours(3),                  'check_out' => now()->subHour()],
            ['member_id' => 2, 'check_in' => now()->subHours(2),                  'check_out' => null],
            ['member_id' => 3, 'check_in' => now()->subDay()->subHours(3),        'check_out' => now()->subDay()->subHours(2)],
            ['member_id' => 4, 'check_in' => now()->subDay()->subHours(5),        'check_out' => now()->subDay()->subHours(4)],
            ['member_id' => 8, 'check_in' => now()->subMinutes(30),               'check_out' => null],
        ]);

        Payment::insert([
            ['invoice_no' => 'INV-1001', 'member_id' => 1, 'plan_id' => 4, 'amount' => 12000, 'method' => 'UPI',            'status' => 'Paid',    'paid_at' => '2026-01-10'],
            ['invoice_no' => 'INV-1002', 'member_id' => 2, 'plan_id' => 2, 'amount' => 4000,  'method' => 'Card',           'status' => 'Paid',    'paid_at' => '2026-03-05'],
            ['invoice_no' => 'INV-1003', 'member_id' => 3, 'plan_id' => 1, 'amount' => 1500,  'method' => 'Cash',           'status' => 'Paid',    'paid_at' => '2026-10-01'],
            ['invoice_no' => 'INV-1004', 'member_id' => 4, 'plan_id' => 3, 'amount' => 7500,  'method' => 'UPI',            'status' => 'Paid',    'paid_at' => '2026-07-15'],
            ['invoice_no' => 'INV-1005', 'member_id' => 8, 'plan_id' => 1, 'amount' => 1500,  'method' => 'Card',           'status' => 'Pending', 'paid_at' => '2026-11-10'],
        ]);
        $this->call(ModsSeeder::class);
    }
}