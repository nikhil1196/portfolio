<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$agents = ['' => '— Unassigned —'] + array_column(qa($app, 'SELECT id,name FROM agents ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Ticket', 'table' => 'tickets',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'customer','label'=>'Customer Name','required'=>true],
        ['name'=>'email','label'=>'Customer Email','type'=>'email'],
        ['name'=>'subject','label'=>'Subject','required'=>true],
        ['name'=>'channel','label'=>'Channel','type'=>'select','options'=>['Email'=>'Email','Chat'=>'Chat','WhatsApp'=>'WhatsApp','Phone'=>'Phone','API'=>'API']],
        ['name'=>'priority','label'=>'Priority','type'=>'select','options'=>['High'=>'High','Medium'=>'Medium','Low'=>'Low']],
        ['name'=>'agent_id','label'=>'Assigned To','type'=>'select','options'=>$agents],
        ['name'=>'ai_summary','label'=>'AI Summary','type'=>'textarea'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Open'=>'Open','In Progress'=>'In Progress','Resolved'=>'Resolved']],
    ],
    'extra' => fn($p) => $p['id'] ? [] : ['ticket_no' => 'TCK-' . str_pad((string)(qv($app, 'SELECT COALESCE(MAX(id),0) FROM tickets') + 9001), 4, '0', STR_PAD_LEFT)],
    'list_sql' => 'SELECT t.*, a.name AS agent FROM tickets t LEFT JOIN agents a ON a.id=t.agent_id ORDER BY t.id DESC',
    'columns' => [
        'Ticket'  => fn($r) => '<code>' . h($r['ticket_no']) . '</code>',
        'Customer'=> fn($r) => '<strong>' . h($r['customer']) . '</strong><br><span class="note">' . h($r['channel']) . '</span>',
        'Subject' => fn($r) => h($r['subject']) . ($r['ai_summary'] ? '<br><span class="note">AI: ' . h(mb_strimwidth($r['ai_summary'], 0, 60, '…')) . '</span>' : ''),
        'Priority'=> fn($r) => status_badge($r['priority']),
        'Agent'   => fn($r) => h($r['agent'] ?? '—'),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
