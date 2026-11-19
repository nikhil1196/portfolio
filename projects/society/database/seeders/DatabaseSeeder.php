<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@demo.local', 'password' => \Illuminate\Support\Facades\Hash::make('admin123')]);
        \App\Models\Unit::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'block' => 'A',
    'flat_no' => 'A-101',
    'floor' => 1,
    'type' => '2 BHK',
    'area_sqft' => 1050,
    'status' => 'Occupied',
  ),
  1 => 
  array (
    'block' => 'A',
    'flat_no' => 'A-102',
    'floor' => 1,
    'type' => '2 BHK',
    'area_sqft' => 1050,
    'status' => 'Occupied',
  ),
  2 => 
  array (
    'block' => 'A',
    'flat_no' => 'A-201',
    'floor' => 2,
    'type' => '3 BHK',
    'area_sqft' => 1400,
    'status' => 'Occupied',
  ),
  3 => 
  array (
    'block' => 'B',
    'flat_no' => 'B-101',
    'floor' => 1,
    'type' => '1 BHK',
    'area_sqft' => 720,
    'status' => 'Occupied',
  ),
  4 => 
  array (
    'block' => 'B',
    'flat_no' => 'B-301',
    'floor' => 3,
    'type' => '3 BHK',
    'area_sqft' => 1450,
    'status' => 'Vacant',
  ),
)));
        \App\Models\Resident::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'unit_id' => 1,
    'name' => 'Mahesh Thakkar',
    'phone' => '9840001111',
    'email' => 'mahesh@example.com',
    'role' => 'Owner',
    'status' => 'Active',
  ),
  1 => 
  array (
    'unit_id' => 2,
    'name' => 'Lata Krishnan',
    'phone' => '9840001112',
    'email' => 'lata@example.com',
    'role' => 'Owner',
    'status' => 'Active',
  ),
  2 => 
  array (
    'unit_id' => 3,
    'name' => 'Nilesh Bhavsar',
    'phone' => '9840001113',
    'email' => 'nilesh@example.com',
    'role' => 'Tenant',
    'status' => 'Active',
  ),
  3 => 
  array (
    'unit_id' => 4,
    'name' => 'Seema Choudhary',
    'phone' => '9840001114',
    'email' => 'seema@example.com',
    'role' => 'Owner',
    'status' => 'Active',
  ),
)));
        \App\Models\Maintenance::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'unit_id' => 1,
    'month' => '2026-11',
    'amount' => 2500,
    'status' => 'Paid',
    'paid_at' => '2026-11-05',
  ),
  1 => 
  array (
    'unit_id' => 2,
    'month' => '2026-11',
    'amount' => 2500,
    'status' => 'Paid',
    'paid_at' => '2026-11-07',
  ),
  2 => 
  array (
    'unit_id' => 3,
    'month' => '2026-11',
    'amount' => 3200,
    'status' => 'Due',
    'paid_at' => NULL,
  ),
  3 => 
  array (
    'unit_id' => 4,
    'month' => '2026-11',
    'amount' => 1800,
    'status' => 'Due',
    'paid_at' => NULL,
  ),
)));
        \App\Models\Complaint::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'resident_id' => 1,
    'category' => 'Plumbing',
    'subject' => 'Leakage in bathroom',
    'description' => 'Water seeping from ceiling.',
    'status' => 'In Progress',
  ),
  1 => 
  array (
    'resident_id' => 2,
    'category' => 'Electrical',
    'subject' => 'Lift not working',
    'description' => 'Block A lift stops on odd floors.',
    'status' => 'Open',
  ),
  2 => 
  array (
    'resident_id' => 3,
    'category' => 'Security',
    'subject' => 'Gate left open',
    'description' => 'Main gate unattended at night.',
    'status' => 'Resolved',
  ),
)));
        \App\Models\Notice::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'title' => 'Water Tank Cleaning',
    'body' => 'Water supply off on Sunday 10 AM - 1 PM.',
    'audience' => 'All',
    'published_at' => '2026-11-08',
  ),
  1 => 
  array (
    'title' => 'AGM Notice',
    'body' => 'Annual General Meeting on Nov 30th.',
    'audience' => 'Owners',
    'published_at' => '2026-11-15',
  ),
)));
        \App\Models\Booking::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'amenity' => 'Community Hall',
    'unit_id' => 1,
    'booking_date' => '2026-11-22',
    'slot' => 'Evening (5-10)',
    'status' => 'Confirmed',
  ),
  1 => 
  array (
    'amenity' => 'Swimming Pool',
    'unit_id' => 3,
    'booking_date' => '2026-11-19',
    'slot' => 'Morning (6-12)',
    'status' => 'Confirmed',
  ),
  2 => 
  array (
    'amenity' => 'Clubhouse',
    'unit_id' => 2,
    'booking_date' => '2026-11-15',
    'slot' => 'Full Day',
    'status' => 'Completed',
  ),
)));
    }
}
