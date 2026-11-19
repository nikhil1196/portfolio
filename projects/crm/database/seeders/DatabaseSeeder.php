<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Role::insert([
            ['name' => 'Admin', 'perms' => '*', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manager', 'perms' => 'contacts,leads,deals,tasks', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Viewer', 'perms' => '', 'created_at' => now(), 'updated_at' => now()],
        ]);
        \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@demo.local', 'password' => \Illuminate\Support\Facades\Hash::make('admin123')]);
        \App\Models\User::where('email', 'admin@demo.local')->update(['role_id' => 1]);
        \App\Models\Contact::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'Rajat Malhotra',
    'company' => 'Zenith Textiles',
    'email' => 'rajat@zenith.com',
    'phone' => '9820100001',
    'source' => 'Referral',
    'status' => 'Active',
  ),
  1 => 
  array (
    'name' => 'Komal Jain',
    'company' => 'FreshMart Retail',
    'email' => 'komal@freshmart.in',
    'phone' => '9820100002',
    'source' => 'Website',
    'status' => 'Active',
  ),
  2 => 
  array (
    'name' => 'Sahil Bhatia',
    'company' => 'Bhatia Logistics',
    'email' => 'sahil@bhatia.co',
    'phone' => '9820100003',
    'source' => 'Cold Call',
    'status' => 'Active',
  ),
  3 => 
  array (
    'name' => 'Tanvi Kulkarni',
    'company' => 'Nimbus IT Park',
    'email' => 'tanvi@nimbus.com',
    'phone' => '9820100004',
    'source' => 'LinkedIn',
    'status' => 'Active',
  ),
)));
        \App\Models\Lead::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'contact_id' => 1,
    'title' => 'ERP for textile unit',
    'value' => 450000,
    'stage' => 'Qualified',
    'owner' => 'Nikhil',
    'notes' => 'Wants GST + inventory module',
  ),
  1 => 
  array (
    'contact_id' => 2,
    'title' => 'POS for 12 stores',
    'value' => 800000,
    'stage' => 'Proposal',
    'owner' => 'Nikhil',
    'notes' => 'Sent pricing deck',
  ),
  2 => 
  array (
    'contact_id' => 3,
    'title' => 'Fleet tracking portal',
    'value' => 250000,
    'stage' => 'Contacted',
    'owner' => 'Amit',
    'notes' => 'Demo scheduled',
  ),
)));
        \App\Models\Deal::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'contact_id' => 1,
    'title' => 'Zenith ERP Phase 1',
    'value' => 300000,
    'stage' => 'Negotiation',
    'close_date' => '2026-12-15',
    'status' => 'Open',
  ),
  1 => 
  array (
    'contact_id' => 2,
    'title' => 'FreshMart POS rollout',
    'value' => 800000,
    'stage' => 'Proposal',
    'close_date' => '2027-01-31',
    'status' => 'Open',
  ),
  2 => 
  array (
    'contact_id' => 3,
    'title' => 'Fleet portal MVP',
    'value' => 250000,
    'stage' => 'Won',
    'close_date' => '2026-11-01',
    'status' => 'Closed',
  ),
)));
        \App\Models\Task::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'contact_id' => 1,
    'title' => 'Send revised ERP quote',
    'due_date' => '2026-11-20',
    'priority' => 'High',
    'status' => 'Open',
  ),
  1 => 
  array (
    'contact_id' => 2,
    'title' => 'POS hardware checklist',
    'due_date' => '2026-11-22',
    'priority' => 'Medium',
    'status' => 'Open',
  ),
)));
        $this->call(ModsSeeder::class);
    }
}
