<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Role::insert([
            ['name' => 'Admin', 'perms' => '*', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manager', 'perms' => 'properties,tenants,leases,rents,requests', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Viewer', 'perms' => '', 'created_at' => now(), 'updated_at' => now()],
        ]);
        \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@demo.local', 'password' => \Illuminate\Support\Facades\Hash::make('admin123')]);
        \App\Models\User::where('email', 'admin@demo.local')->update(['role_id' => 1]);
        \App\Models\Property::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'title' => 'Sunrise Residency 2BHK',
    'type' => 'Apartment',
    'address' => 'Alkapuri',
    'city' => 'Vadodara',
    'rent' => 18000,
    'status' => 'Occupied',
  ),
  1 => 
  array (
    'title' => 'Green Villa 3BHK',
    'type' => 'Villa',
    'address' => 'Gotri',
    'city' => 'Vadodara',
    'rent' => 35000,
    'status' => 'Occupied',
  ),
  2 => 
  array (
    'title' => 'Lakeview Studio',
    'type' => 'Studio',
    'address' => 'Fatehgunj',
    'city' => 'Vadodara',
    'rent' => 12000,
    'status' => 'Available',
  ),
  3 => 
  array (
    'title' => 'Skyline Office 800sqft',
    'type' => 'Commercial',
    'address' => 'Sayajigunj',
    'city' => 'Vadodara',
    'rent' => 45000,
    'status' => 'Occupied',
  ),
)));
        \App\Models\Tenant::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'Deepak Rana',
    'phone' => '9811100001',
    'email' => 'deepak@example.com',
    'id_proof' => 'Aadhaar XXXX1234',
    'status' => 'Active',
  ),
  1 => 
  array (
    'name' => 'Shreya Nambiar',
    'phone' => '9811100002',
    'email' => 'shreya@example.com',
    'id_proof' => 'PAN XXXX5678',
    'status' => 'Active',
  ),
  2 => 
  array (
    'name' => 'Wasim Pathan',
    'phone' => '9811100003',
    'email' => 'wasim@example.com',
    'id_proof' => 'Aadhaar XXXX9012',
    'status' => 'Active',
  ),
)));
        \App\Models\Lease::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'property_id' => 1,
    'tenant_id' => 1,
    'start_date' => '2026-01-01',
    'end_date' => '2026-12-31',
    'rent' => 18000,
    'deposit' => 54000,
    'status' => 'Active',
  ),
  1 => 
  array (
    'property_id' => 2,
    'tenant_id' => 2,
    'start_date' => '2026-04-01',
    'end_date' => '2027-03-31',
    'rent' => 35000,
    'deposit' => 105000,
    'status' => 'Active',
  ),
  2 => 
  array (
    'property_id' => 4,
    'tenant_id' => 3,
    'start_date' => '2026-06-01',
    'end_date' => '2029-05-31',
    'rent' => 45000,
    'deposit' => 135000,
    'status' => 'Active',
  ),
)));
        \App\Models\Rent::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'lease_id' => 1,
    'month' => '2026-11',
    'amount' => 18000,
    'status' => 'Paid',
    'paid_at' => '2026-11-03',
  ),
  1 => 
  array (
    'lease_id' => 2,
    'month' => '2026-11',
    'amount' => 35000,
    'status' => 'Due',
    'paid_at' => NULL,
  ),
  2 => 
  array (
    'lease_id' => 3,
    'month' => '2026-11',
    'amount' => 45000,
    'status' => 'Paid',
    'paid_at' => '2026-11-08',
  ),
)));
        \App\Models\MaintenanceRequest::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'property_id' => 1,
    'tenant_id' => 1,
    'category' => 'Plumbing',
    'subject' => 'Kitchen tap leaking',
    'status' => 'In Progress',
  ),
  1 => 
  array (
    'property_id' => 2,
    'tenant_id' => 2,
    'category' => 'Electrical',
    'subject' => 'Bedroom fan not working',
    'status' => 'Open',
  ),
)));
    }
}
