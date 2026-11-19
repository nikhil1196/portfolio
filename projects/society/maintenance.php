<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$units = ['' => '— Unit —'] + array_column(qa($app, 'SELECT id, flat_no FROM units ORDER BY flat_no'), 'flat_no', 'id');
crud_page($app, [
    'title' => 'Maintenance Bill', 'table' => 'maintenance',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'unit_id','label'=>'Unit','type'=>'select','options'=>$units,'required'=>true],
        ['name'=>'month','label'=>'Month','type'=>'month','required'=>true],
        ['name'=>'amount','label'=>'Amount (₹)','type'=>'number','step'=>'0.01','required'=>true],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Paid'=>'Paid','Due'=>'Due','Overdue'=>'Overdue']],
        ['name'=>'paid_at','label'=>'Paid On','type'=>'date'],
    ],
    'list_sql' => 'SELECT m.*, u.flat_no FROM maintenance m LEFT JOIN units u ON u.id=m.unit_id ORDER BY m.month DESC, u.flat_no',
    'columns' => [
        'Flat'   => fn($r) => '<strong>' . h($r['flat_no']) . '</strong>',
        'Month'  => fn($r) => h(dt($r['month'] . '-01', 'M Y')),
        'Amount' => fn($r) => money($r['amount']),
        'Paid On'=> fn($r) => dt($r['paid_at']),
        'Status' => fn($r) => status_badge($r['status']),
    ],
]);
