<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Event', 'table' => 'events',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'title','label'=>'Event Title','required'=>true],
        ['name'=>'category','label'=>'Category','type'=>'select','options'=>['Tech'=>'Tech','Concert'=>'Concert','Business'=>'Business','Workshop'=>'Workshop','Sports'=>'Sports','Other'=>'Other']],
        ['name'=>'venue','label'=>'Venue'],
        ['name'=>'event_date','label'=>'Date & Time','type'=>'datetime-local','required'=>true],
        ['name'=>'price','label'=>'Base Price (₹)','type'=>'number','step'=>'0.01'],
        ['name'=>'capacity','label'=>'Capacity','type'=>'number'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Published'=>'Published','Draft'=>'Draft','Cancelled'=>'Cancelled']],
    ],
    'list_sql' => "SELECT e.*, (SELECT COALESCE(SUM(b.seats),0) FROM bookings b WHERE b.event_id=e.id AND b.status='Confirmed') AS booked FROM events e ORDER BY e.event_date DESC",
    'columns' => [
        'Event'   => fn($r) => '<strong>' . h($r['title']) . '</strong><br><span class="note">' . h($r['category']) . '</span>',
        'Venue'   => fn($r) => h($r['venue']),
        'Date'    => fn($r) => dt($r['event_date'], 'd M Y, h:i A'),
        'Price'   => fn($r) => $r['price'] ? money($r['price']) : 'Free',
        'Booked'  => fn($r) => h($r['booked']) . ' / ' . h($r['capacity']),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
