<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$events = ['' => '— Event —'] + array_column(qa($app, 'SELECT id,title FROM events ORDER BY event_date DESC'), 'title', 'id');
crud_page($app, [
    'title' => 'Booking', 'table' => 'bookings',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'event_id','label'=>'Event','type'=>'select','options'=>$events,'required'=>true],
        ['name'=>'name','label'=>'Booked By','required'=>true],
        ['name'=>'email','label'=>'Email','type'=>'email'],
        ['name'=>'seats','label'=>'Seats','type'=>'number','required'=>true],
        ['name'=>'amount','label'=>'Amount (₹)','type'=>'number','step'=>'0.01'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Confirmed'=>'Confirmed','Cancelled'=>'Cancelled','Refunded'=>'Refunded']],
    ],
    'extra' => fn($p) => $p['id'] ? [] : ['booking_no' => 'BKG-' . str_pad((string)(qv($app, 'SELECT COALESCE(MAX(id),0) FROM bookings') + 5001), 4, '0', STR_PAD_LEFT)],
    'list_sql' => 'SELECT b.*, e.title AS event FROM bookings b LEFT JOIN events e ON e.id=b.event_id ORDER BY b.id DESC',
    'columns' => [
        'Booking' => fn($r) => '<code>' . h($r['booking_no']) . '</code>',
        'Event'   => fn($r) => h($r['event'] ?? '—'),
        'By'      => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Seats'   => fn($r) => h($r['seats']),
        'Amount'  => fn($r) => money($r['amount']),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
