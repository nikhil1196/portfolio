<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$students = ['' => '— Student —'] + array_column(qa($app, 'SELECT id,name FROM students ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Fee', 'table' => 'fees',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'student_id','label'=>'Student','type'=>'select','options'=>$students,'required'=>true],
        ['name'=>'term','label'=>'Term','type'=>'select','options'=>['Term 1'=>'Term 1','Term 2'=>'Term 2','Term 3'=>'Term 3','Annual'=>'Annual']],
        ['name'=>'amount','label'=>'Amount (₹)','type'=>'number','step'=>'0.01','required'=>true],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Paid'=>'Paid','Pending'=>'Pending','Overdue'=>'Overdue']],
        ['name'=>'paid_at','label'=>'Date','type'=>'date'],
    ],
    'extra' => fn($p) => $p['id'] ? [] : ['receipt_no' => 'RCP-' . str_pad((string)(qv($app, 'SELECT COALESCE(MAX(id),0) FROM fees') + 2001), 4, '0', STR_PAD_LEFT)],
    'list_sql' => 'SELECT f.*, s.name AS student, s.roll_no FROM fees f LEFT JOIN students s ON s.id=f.student_id ORDER BY f.id DESC',
    'columns' => [
        'Receipt' => fn($r) => '<code>' . h($r['receipt_no']) . '</code>',
        'Student' => fn($r) => '<strong>' . h($r['student']) . '</strong><br><span class="note">' . h($r['roll_no']) . '</span>',
        'Term'    => fn($r) => h($r['term']),
        'Amount'  => fn($r) => money($r['amount']),
        'Date'    => fn($r) => dt($r['paid_at']),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
