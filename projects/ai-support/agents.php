<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Agent', 'table' => 'agents',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'name','label'=>'Agent Name','required'=>true],
        ['name'=>'email','label'=>'Email','type'=>'email'],
        ['name'=>'role','label'=>'Role','type'=>'select','options'=>['Agent'=>'Agent','Team Lead'=>'Team Lead','AI Assistant'=>'AI Assistant']],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Inactive'=>'Inactive']],
    ],
    'list_sql' => 'SELECT a.*, (SELECT COUNT(*) FROM tickets t WHERE t.agent_id=a.id) AS tickets FROM agents a ORDER BY a.name',
    'columns' => [
        'Name'   => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Email'  => fn($r) => h($r['email']),
        'Role'   => fn($r) => $r['role'] === 'AI Assistant' ? status_badge('AI') : h($r['role']),
        'Tickets'=> fn($r) => h($r['tickets']),
        'Status' => fn($r) => status_badge($r['status']),
    ],
]);
