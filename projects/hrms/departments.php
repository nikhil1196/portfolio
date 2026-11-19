<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Department', 'table' => 'departments',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'name','label'=>'Department Name','required'=>true],
        ['name'=>'head','label'=>'Department Head'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Inactive'=>'Inactive']],
    ],
    'list_sql' => 'SELECT d.*, (SELECT COUNT(*) FROM employees e WHERE e.dept_id=d.id) AS staff FROM departments d ORDER BY d.name',
    'columns' => [
        'Department'=> fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Head'      => fn($r) => h($r['head']),
        'Staff'     => fn($r) => h($r['staff']),
        'Status'    => fn($r) => status_badge($r['status']),
    ],
]);
