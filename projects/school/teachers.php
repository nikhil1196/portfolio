<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Teacher', 'table' => 'teachers',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'name','label'=>'Teacher Name','required'=>true],
        ['name'=>'subject','label'=>'Subject'],
        ['name'=>'phone','label'=>'Phone','type'=>'tel'],
        ['name'=>'qualification','label'=>'Qualification','placeholder'=>'e.g. M.Sc, B.Ed'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Inactive'=>'Inactive']],
    ],
    'list_sql' => 'SELECT t.*, (SELECT COUNT(*) FROM classes c WHERE c.teacher_id=t.id) AS classes FROM teachers t ORDER BY t.name',
    'columns' => [
        'Name'         => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Subject'      => fn($r) => h($r['subject']),
        'Qualification'=> fn($r) => h($r['qualification']),
        'Phone'        => fn($r) => h($r['phone']),
        'Classes'      => fn($r) => h($r['classes']),
        'Status'       => fn($r) => status_badge($r['status']),
    ],
]);
