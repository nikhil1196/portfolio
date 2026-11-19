<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$emps = ['' => '— Employee —'] + array_column(qa($app, "SELECT id, name FROM employees WHERE status='Active' ORDER BY name"), 'name', 'id');
crud_page($app, [
    'title' => 'Attendance', 'table' => 'attendance',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'emp_id','label'=>'Employee','type'=>'select','options'=>$emps,'required'=>true],
        ['name'=>'work_date','label'=>'Date','type'=>'date','required'=>true],
        ['name'=>'check_in','label'=>'Check-in Time','type'=>'time'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Present'=>'Present','Absent'=>'Absent','Leave'=>'Leave','Half Day'=>'Half Day','WFH'=>'WFH']],
    ],
    'list_sql' => 'SELECT a.*, e.name, e.emp_code FROM attendance a LEFT JOIN employees e ON e.id=a.emp_id ORDER BY a.work_date DESC, e.name',
    'columns' => [
        'Date'    => fn($r) => dt($r['work_date']),
        'Employee'=> fn($r) => '<strong>' . h($r['name']) . '</strong><br><span class="note">' . h($r['emp_code']) . '</span>',
        'Check-in'=> fn($r) => h($r['check_in'] ?: '—'),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
