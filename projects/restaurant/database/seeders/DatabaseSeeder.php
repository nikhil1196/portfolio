<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@demo.local', 'password' => \Illuminate\Support\Facades\Hash::make('admin123')]);
        \App\Models\MenuItem::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'Paneer Tikka',
    'category' => 'Starters',
    'price' => 240,
    'available' => 1,
  ),
  1 => 
  array (
    'name' => 'Veg Manchurian',
    'category' => 'Starters',
    'price' => 180,
    'available' => 1,
  ),
  2 => 
  array (
    'name' => 'Butter Naan',
    'category' => 'Breads',
    'price' => 50,
    'available' => 1,
  ),
  3 => 
  array (
    'name' => 'Paneer Butter Masala',
    'category' => 'Mains',
    'price' => 280,
    'available' => 1,
  ),
  4 => 
  array (
    'name' => 'Dal Tadka',
    'category' => 'Mains',
    'price' => 190,
    'available' => 1,
  ),
  5 => 
  array (
    'name' => 'Veg Biryani',
    'category' => 'Mains',
    'price' => 220,
    'available' => 1,
  ),
  6 => 
  array (
    'name' => 'Masala Dosa',
    'category' => 'South Indian',
    'price' => 160,
    'available' => 1,
  ),
  7 => 
  array (
    'name' => 'Cold Coffee',
    'category' => 'Beverages',
    'price' => 120,
    'available' => 1,
  ),
  8 => 
  array (
    'name' => 'Gulab Jamun',
    'category' => 'Desserts',
    'price' => 90,
    'available' => 1,
  ),
)));
        \App\Models\DiningTable::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'T1',
    'seats' => 2,
    'status' => 'Occupied',
  ),
  1 => 
  array (
    'name' => 'T2',
    'seats' => 4,
    'status' => 'Occupied',
  ),
  2 => 
  array (
    'name' => 'T3',
    'seats' => 4,
    'status' => 'Free',
  ),
  3 => 
  array (
    'name' => 'T4',
    'seats' => 6,
    'status' => 'Free',
  ),
  4 => 
  array (
    'name' => 'T5',
    'seats' => 2,
    'status' => 'Free',
  ),
  5 => 
  array (
    'name' => 'T6',
    'seats' => 8,
    'status' => 'Reserved',
  ),
)));
        \App\Models\Order::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'order_no' => 'ORD-1001',
    'table_id' => 1,
    'status' => 'Preparing',
    'total' => 710,
    'payment' => 'Unpaid',
  ),
  1 => 
  array (
    'order_no' => 'ORD-1002',
    'table_id' => 2,
    'status' => 'Pending',
    'total' => 430,
    'payment' => 'Unpaid',
  ),
  2 => 
  array (
    'order_no' => 'ORD-1003',
    'table_id' => 3,
    'status' => 'Served',
    'total' => 520,
    'payment' => 'Paid',
  ),
)));
        \App\Models\OrderItem::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'order_id' => 1,
    'item_name' => 'Paneer Tikka',
    'qty' => 1,
    'price' => 240,
  ),
  1 => 
  array (
    'order_id' => 1,
    'item_name' => 'Butter Naan',
    'qty' => 4,
    'price' => 50,
  ),
  2 => 
  array (
    'order_id' => 1,
    'item_name' => 'Dal Tadka',
    'qty' => 1,
    'price' => 190,
  ),
  3 => 
  array (
    'order_id' => 2,
    'item_name' => 'Veg Manchurian',
    'qty' => 1,
    'price' => 180,
  ),
  4 => 
  array (
    'order_id' => 2,
    'item_name' => 'Paneer Butter Masala',
    'qty' => 1,
    'price' => 280,
  ),
  5 => 
  array (
    'order_id' => 3,
    'item_name' => 'Masala Dosa',
    'qty' => 2,
    'price' => 160,
  ),
  6 => 
  array (
    'order_id' => 3,
    'item_name' => 'Cold Coffee',
    'qty' => 2,
    'price' => 120,
  ),
)));
    }
}
