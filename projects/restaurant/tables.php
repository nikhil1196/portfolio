<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Table', 'table' => 'tables',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'name','label'=>'Table Name','required'=>true,'placeholder'=>'e.g. T7'],
        ['name'=>'seats','label'=>'Seats','type'=>'number'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Free'=>'Free','Occupied'=>'Occupied','Reserved'=>'Reserved']],
    ],
    'list_sql' => 'SELECT t.*, (SELECT COUNT(*) FROM orders o WHERE o.table_id=t.id) AS orders FROM tables t ORDER BY t.name',
    'columns' => [
        'Table' => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Seats' => fn($r) => h($r['seats']),
        'Orders'=> fn($r) => h($r['orders']),
        'Status'=> fn($r) => status_badge($r['status']),
    ],
]);
