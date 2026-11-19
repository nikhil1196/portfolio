<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$depts = ['' => '— Department —'] + array_column(qa($app, 'SELECT id,name FROM departments ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Employee', 'table' => 'employees',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'emp_code','label'=>'Emp Code','placeholder'=>'e.g. EMP-006'],
        ['name'=>'name','label'=>'Full Name','required'=>true],
        ['name'=>'dept_id','label'=>'Department','type'=>'select','options'=>$depts],
        ['name'=>'designation','label'=>'Designation'],
        ['name'=>'email','label'=>'Email','type'=>'email'],
        ['name'=>'phone','label'=>'Phone','type'=>'tel'],
        ['name'=>'joining_date','label'=>'Joining Date','type'=>'date'],
        ['name'=>'salary','label'=>'Salary (₹/mo)','type'=>'number','step'=>'0.01'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','On Notice'=>'On Notice','Exited'=>'Exited']],
    ],
    'list_sql' => 'SELECT e.*, d.name AS dept FROM employees e LEFT JOIN departments d ON d.id=e.dept_id ORDER BY e.id DESC',
    'columns' => [
        'Code'  => fn($r) => '<code>' . h($r['emp_code']) . '</code>',
        'Name'  => fn($r) => '<strong>' . h($r['name']) . '</strong><br><span class="note">' . h($r['designation']) . '</span>',
        'Dept'  => fn($r) => h($r['dept'] ?? '—'),
        'Joined'=> fn($r) => dt($r['joining_date']),
        'Salary'=> fn($r) => money($r['salary']),
        'Status'=> fn($r) => status_badge($r['status']),
    ],
]);
