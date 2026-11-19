<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$contacts = ['' => '— Contact —'] + array_column(qa($app, 'SELECT id,name FROM contacts ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Lead', 'table' => 'leads',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'contact_id','label'=>'Contact','type'=>'select','options'=>$contacts],
        ['name'=>'title','label'=>'Lead Title','required'=>true],
        ['name'=>'value','label'=>'Est. Value (₹)','type'=>'number','step'=>'0.01'],
        ['name'=>'stage','label'=>'Stage','type'=>'select','options'=>['New'=>'New','Contacted'=>'Contacted','Qualified'=>'Qualified','Proposal'=>'Proposal','Negotiation'=>'Negotiation','Won'=>'Won','Lost'=>'Lost']],
        ['name'=>'owner','label'=>'Owner'],
        ['name'=>'notes','label'=>'Notes','type'=>'textarea'],
    ],
    'list_sql' => 'SELECT l.*, c.name AS contact, c.company FROM leads l LEFT JOIN contacts c ON c.id=l.contact_id ORDER BY l.id DESC',
    'columns' => [
        'Lead'    => fn($r) => '<strong>' . h($r['title']) . '</strong>',
        'Contact' => fn($r) => h($r['contact'] ?? '—') . '<br><span class="note">' . h($r['company'] ?? '') . '</span>',
        'Value'   => fn($r) => money($r['value']),
        'Stage'   => fn($r) => status_badge($r['stage']),
        'Owner'   => fn($r) => h($r['owner']),
    ],
]);
