<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$events = ['' => '— Event —'] + array_column(qa($app, 'SELECT id,title FROM events ORDER BY event_date DESC'), 'title', 'id');
crud_page($app, [
    'title' => 'Ticket Tier', 'table' => 'tickets',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'event_id','label'=>'Event','type'=>'select','options'=>$events,'required'=>true],
        ['name'=>'name','label'=>'Tier Name','required'=>true,'placeholder'=>'e.g. VIP'],
        ['name'=>'price','label'=>'Price (₹)','type'=>'number','step'=>'0.01','required'=>true],
        ['name'=>'qty','label'=>'Quantity','type'=>'number','required'=>true],
    ],
    'list_sql' => 'SELECT t.*, e.title AS event FROM tickets t LEFT JOIN events e ON e.id=t.event_id ORDER BY t.id DESC',
    'columns' => [
        'Event' => fn($r) => h($r['event'] ?? '—'),
        'Tier'  => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Price' => fn($r) => money($r['price']),
        'Qty'   => fn($r) => h($r['qty']),
    ],
]);
