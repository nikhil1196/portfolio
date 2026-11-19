<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$teachers = ['' => '— Class Teacher —'] + array_column(qa($app, "SELECT id,name FROM teachers WHERE status='Active' ORDER BY name"), 'name', 'id');
crud_page($app, [
    'title' => 'Class', 'table' => 'classes',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'name','label'=>'Class Name','required'=>true,'placeholder'=>'e.g. Class 10'],
        ['name'=>'section','label'=>'Section','placeholder'=>'e.g. A'],
        ['name'=>'teacher_id','label'=>'Class Teacher','type'=>'select','options'=>$teachers],
        ['name'=>'room','label'=>'Room No','placeholder'=>'e.g. R-104'],
    ],
    'list_sql' => "SELECT c.*, t.name AS teacher, (SELECT COUNT(*) FROM students s WHERE s.class_id=c.id) AS students FROM classes c LEFT JOIN teachers t ON t.id=c.teacher_id ORDER BY c.name, c.section",
    'columns' => [
        'Class'   => fn($r) => '<strong>' . h($r['name'] . ' ' . $r['section']) . '</strong>',
        'Teacher' => fn($r) => h($r['teacher'] ?? '—'),
        'Room'    => fn($r) => h($r['room']),
        'Students'=> fn($r) => h($r['students']),
    ],
]);
