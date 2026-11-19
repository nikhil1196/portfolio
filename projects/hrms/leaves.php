<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$emps = ['' => '— Employee —'] + array_column(qa($app, "SELECT id, name FROM employees WHERE status='Active' ORDER BY name"), 'name', 'id');
crud_page($app, [
    'title' => 'Leave', 'table' => 'leaves',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'emp_id','label'=>'Employee','type'=>'select','options'=>$emps,'required'=>true],
        ['name'=>'type','label'=>'Leave Type','type'=>'select','options'=>['Casual'=>'Casual','Sick'=>'Sick','Earned'=>'Earned','Unpaid'=>'Unpaid']],
        ['name'=>'from_date','label'=>'From','type'=>'date','required'=>true],
        ['name'=>'to_date','label'=>'To','type'=>'date','required'=>true],
        ['name'=>'reason','label'=>'Reason','type'=>'textarea'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Pending'=>'Pending','Approved'=>'Approved','Rejected'=>'Rejected']],
    ],
    'list_sql' => 'SELECT l.*, e.name, e.emp_code FROM leaves l LEFT JOIN employees e ON e.id=l.emp_id ORDER BY l.id DESC',
    'columns' => [
        'Employee'=> fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Type'    => fn($r) => h($r['type']),
        'From'    => fn($r) => dt($r['from_date']),
        'To'      => fn($r) => dt($r['to_date']),
        'Reason'  => fn($r) => h(mb_strimwidth($r['reason'] ?? '', 0, 40, '…')),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
