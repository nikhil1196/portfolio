<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@demo.local', 'password' => \Illuminate\Support\Facades\Hash::make('admin123')]);
        \App\Models\Agent::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'name' => 'Support Bot',
    'email' => 'bot@help.local',
    'role' => 'AI Assistant',
    'status' => 'Active',
  ),
  1 => 
  array (
    'name' => 'Kunal Deshmukh',
    'email' => 'kunal@example.com',
    'role' => 'Agent',
    'status' => 'Active',
  ),
  2 => 
  array (
    'name' => 'Farida Memon',
    'email' => 'farida@example.com',
    'role' => 'Team Lead',
    'status' => 'Active',
  ),
)));
        \App\Models\SupportTicket::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'ticket_no' => 'TCK-9001',
    'customer' => 'Om Prakash',
    'email' => 'om@example.com',
    'subject' => 'Payment failed but amount debited',
    'channel' => 'Email',
    'priority' => 'High',
    'status' => 'Open',
    'agent_id' => 2,
    'ai_summary' => 'Customer charged twice; needs refund in 5-7 days.',
  ),
  1 => 
  array (
    'ticket_no' => 'TCK-9002',
    'customer' => 'Lisa D\'Souza',
    'email' => 'lisa@example.com',
    'subject' => 'How to export invoices to PDF?',
    'channel' => 'Chat',
    'priority' => 'Low',
    'status' => 'Resolved',
    'agent_id' => 1,
    'ai_summary' => 'How-to query; bot shared KB-12.',
  ),
  2 => 
  array (
    'ticket_no' => 'TCK-9003',
    'customer' => 'Harsh Vora',
    'email' => 'harsh@example.com',
    'subject' => 'API returning 429 errors',
    'channel' => 'API',
    'priority' => 'High',
    'status' => 'In Progress',
    'agent_id' => 3,
    'ai_summary' => 'Rate-limit hit; suggest upgrading plan.',
  ),
)));
        \App\Models\Reply::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'ticket_id' => 1,
    'author' => 'Support Bot',
    'body' => 'I\'ve detected a duplicate charge. Flagged for billing team — refund in 5-7 business days.',
    'is_ai' => 1,
  ),
  1 => 
  array (
    'ticket_id' => 1,
    'author' => 'Kunal Deshmukh',
    'body' => 'Confirmed duplicate charge. Refund reference RF-2211 created.',
    'is_ai' => 0,
  ),
)));
        \App\Models\KbArticle::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'title' => 'Exporting invoices to PDF',
    'category' => 'Billing',
    'body' => 'Go to Billing > Invoices, select date range, click Export > PDF.',
    'views' => 142,
    'status' => 'Published',
  ),
  1 => 
  array (
    'title' => 'Understanding API rate limits',
    'category' => 'API',
    'body' => 'Free plan: 100 req/min. Pro: 1000 req/min.',
    'views' => 89,
    'status' => 'Published',
  ),
  2 => 
  array (
    'title' => 'Refund policy and timelines',
    'category' => 'Billing',
    'body' => 'Refunds process in 5-7 business days.',
    'views' => 175,
    'status' => 'Published',
  ),
)));
        \App\Models\CannedReply::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], array (
  0 => 
  array (
    'title' => 'Refund initiated',
    'body' => 'Your refund has been initiated and will reflect in 5-7 business days.',
    'category' => 'Billing',
  ),
  1 => 
  array (
    'title' => 'Welcome greeting',
    'body' => 'Hi {name}, thanks for reaching out! How can I help you today?',
    'category' => 'General',
  ),
  2 => 
  array (
    'title' => 'Escalation note',
    'body' => 'I\'m escalating this to our senior team — you\'ll hear back within 24 hours.',
    'category' => 'General',
  ),
)));
    }
}
