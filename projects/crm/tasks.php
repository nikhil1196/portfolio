<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$contacts = ['' => '— Contact —'] + array_column(qa($app, 'SELECT id,name FROM contacts ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Task', 'table' => 'tasks',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'contact_id','label'=>'Contact','type'=>'select','options'=>$contacts],
        ['name'=>'title','label'=>'Task','required'=>true],
        ['name'=>'due_date','label'=>'Due Date','type'=>'date','required'=>true],
        ['name'=>'priority','label'=>'Priority','type'=>'select','options'=>['High'=>'High','Medium'=>'Medium','Low'=>'Low']],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Open'=>'Open','Done'=>'Done','Cancelled'=>'Cancelled']],
    ],
    'list_sql' => 'SELECT t.*, c.name AS contact FROM tasks t LEFT JOIN contacts c ON c.id=t.contact_id ORDER BY t.status, t.due_date',
    'columns' => [
        'Task'    => fn($r) => '<strong>' . h($r['title']) . '</strong>',
        'Contact' => fn($r) => h($r['contact'] ?? '—'),
        'Due'     => fn($r) => dt($r['due_date']),
        'Priority'=> fn($r) => status_badge($r['priority']),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
