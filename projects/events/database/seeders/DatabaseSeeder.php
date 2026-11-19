<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Role::insert([
            ['name' => 'Admin', 'perms' => '*', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manager', 'perms' => 'events,tickets,bookings,attendees', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Viewer', 'perms' => '', 'created_at' => now(), 'updated_at' => now()],
        ]);
        \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@demo.local', 'password' => \Illuminate\Support\Facades\Hash::make('admin123')]);
        \App\Models\User::where('email', 'admin@demo.local')->update(['role_id' => 1]);
        \App\Models\Event::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'title' => 'Laravel Meetup Vadodara',
    'category' => 'Tech',
    'venue' => 'Sayaji Convention Center',
    'event_date' => '2026-12-14 10:00',
    'price' => 0,
    'capacity' => 150,
    'status' => 'Published',
  ),
  1 => 
  array (
    'title' => 'Indie Music Night',
    'category' => 'Concert',
    'venue' => 'Open Air Amphitheatre',
    'event_date' => '2026-12-21 19:00',
    'price' => 499,
    'capacity' => 500,
    'status' => 'Published',
  ),
  2 => 
  array (
    'title' => 'Startup Founders Summit',
    'category' => 'Business',
    'venue' => 'Grand Meridian Hotel',
    'event_date' => '2027-01-10 09:00',
    'price' => 1999,
    'capacity' => 200,
    'status' => 'Published',
  ),
  3 => 
  array (
    'title' => 'Kids Art Workshop',
    'category' => 'Workshop',
    'venue' => 'Creative Studio Space',
    'event_date' => '2026-12-07 11:00',
    'price' => 350,
    'capacity' => 40,
    'status' => 'Published',
  ),
)));
        \App\Models\Ticket::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'event_id' => 2,
    'name' => 'General Admission',
    'price' => 499,
    'qty' => 400,
  ),
  1 => 
  array (
    'event_id' => 2,
    'name' => 'VIP',
    'price' => 1499,
    'qty' => 100,
  ),
  2 => 
  array (
    'event_id' => 3,
    'name' => 'Early Bird',
    'price' => 1499,
    'qty' => 50,
  ),
  3 => 
  array (
    'event_id' => 4,
    'name' => 'Single Seat',
    'price' => 350,
    'qty' => 40,
  ),
)));
        \App\Models\Booking::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'booking_no' => 'BKG-5001',
    'event_id' => 2,
    'name' => 'Aditya Verma',
    'email' => 'aditya@example.com',
    'seats' => 2,
    'amount' => 998,
    'status' => 'Confirmed',
  ),
  1 => 
  array (
    'booking_no' => 'BKG-5002',
    'event_id' => 3,
    'name' => 'Nidhi Saxena',
    'email' => 'nidhi@example.com',
    'seats' => 1,
    'amount' => 1499,
    'status' => 'Confirmed',
  ),
  2 => 
  array (
    'booking_no' => 'BKG-5003',
    'event_id' => 2,
    'name' => 'Rahul Dube',
    'email' => 'rahul@example.com',
    'seats' => 4,
    'amount' => 1996,
    'status' => 'Confirmed',
  ),
)));
        \App\Models\Attendee::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'booking_id' => 1,
    'name' => 'Aditya Verma',
    'checked_in' => 0,
  ),
  1 => 
  array (
    'booking_id' => 2,
    'name' => 'Nidhi Saxena',
    'checked_in' => 0,
  ),
  2 => 
  array (
    'booking_id' => 3,
    'name' => 'Rahul Dube',
    'checked_in' => 0,
  ),
)));
        $this->call(ModsSeeder::class);
    }
}
