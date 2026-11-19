<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$students = ['' => '— Student —'] + array_column(qa($app, 'SELECT id,name FROM students ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Result', 'table' => 'results',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'student_id','label'=>'Student','type'=>'select','options'=>$students,'required'=>true],
        ['name'=>'exam','label'=>'Exam','placeholder'=>'e.g. Mid-Term'],
        ['name'=>'subject','label'=>'Subject','required'=>true],
        ['name'=>'marks','label'=>'Marks','type'=>'number','step'=>'0.01','required'=>true],
        ['name'=>'max_marks','label'=>'Max Marks','type'=>'number','step'=>'0.01'],
        ['name'=>'grade','label'=>'Grade','placeholder'=>'e.g. A+'],
    ],
    'list_sql' => 'SELECT r.*, s.name AS student, s.roll_no FROM results r LEFT JOIN students s ON s.id=r.student_id ORDER BY r.id DESC',
    'columns' => [
        'Student' => fn($r) => '<strong>' . h($r['student']) . '</strong><br><span class="note">' . h($r['roll_no']) . '</span>',
        'Exam'    => fn($r) => h($r['exam']),
        'Subject' => fn($r) => h($r['subject']),
        'Marks'   => fn($r) => h($r['marks']) . ' / ' . h($r['max_marks']),
        'Grade'   => fn($r) => status_badge($r['grade']),
    ],
]);
