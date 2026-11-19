<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$contacts = ['' => '— Contact —'] + array_column(qa($app, 'SELECT id,name FROM contacts ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Deal', 'table' => 'deals',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'contact_id','label'=>'Contact','type'=>'select','options'=>$contacts,'required'=>true],
        ['name'=>'title','label'=>'Deal Title','required'=>true],
        ['name'=>'value','label'=>'Deal Value (₹)','type'=>'number','step'=>'0.01','required'=>true],
        ['name'=>'stage','label'=>'Stage','type'=>'select','options'=>['Qualification'=>'Qualification','Proposal'=>'Proposal','Negotiation'=>'Negotiation','Won'=>'Won','Lost'=>'Lost']],
        ['name'=>'close_date','label'=>'Expected Close','type'=>'date'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Open'=>'Open','Closed'=>'Closed']],
    ],
    'list_sql' => 'SELECT d.*, c.name AS contact FROM deals d LEFT JOIN contacts c ON c.id=d.contact_id ORDER BY d.id DESC',
    'columns' => [
        'Deal'  => fn($r) => '<strong>' . h($r['title']) . '</strong>',
        'Contact'=> fn($r) => h($r['contact'] ?? '—'),
        'Value' => fn($r) => money($r['value']),
        'Stage' => fn($r) => status_badge($r['stage']),
        'Close' => fn($r) => dt($r['close_date']),
        'Status'=> fn($r) => status_badge($r['status']),
    ],
]);
