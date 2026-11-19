<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$classes = ['' => '— Class —'] + array_column(qa($app, "SELECT id, name||' '||COALESCE(section,'') AS n FROM classes ORDER BY name"), 'n', 'id');
crud_page($app, [
    'title' => 'Student', 'table' => 'students',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'name','label'=>'Student Name','required'=>true],
        ['name'=>'roll_no','label'=>'Roll No','placeholder'=>'e.g. 10A-01'],
        ['name'=>'class_id','label'=>'Class','type'=>'select','options'=>$classes,'required'=>true],
        ['name'=>'guardian','label'=>'Guardian Name'],
        ['name'=>'phone','label'=>'Phone','type'=>'tel'],
        ['name'=>'dob','label'=>'Date of Birth','type'=>'date'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Inactive'=>'Inactive','Alumni'=>'Alumni']],
    ],
    'list_sql' => "SELECT s.*, c.name||' '||COALESCE(c.section,'') AS class FROM students s LEFT JOIN classes c ON c.id=s.class_id ORDER BY s.id DESC",
    'columns' => [
        'Roll'    => fn($r) => '<code>' . h($r['roll_no']) . '</code>',
        'Name'    => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Class'   => fn($r) => h($r['class'] ?? '—'),
        'Guardian'=> fn($r) => h($r['guardian']),
        'Phone'   => fn($r) => h($r['phone']),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
