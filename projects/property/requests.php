<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$props   = ['' => '— Property —'] + array_column(qa($app, 'SELECT id,title FROM properties ORDER BY title'), 'title', 'id');
$tenants = ['' => '— Tenant —'] + array_column(qa($app, 'SELECT id,name FROM tenants ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Maintenance Request', 'table' => 'requests',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'property_id','label'=>'Property','type'=>'select','options'=>$props,'required'=>true],
        ['name'=>'tenant_id','label'=>'Raised By','type'=>'select','options'=>$tenants],
        ['name'=>'category','label'=>'Category','type'=>'select','options'=>['Plumbing'=>'Plumbing','Electrical'=>'Electrical','Carpentry'=>'Carpentry','General'=>'General','Pest Control'=>'Pest Control']],
        ['name'=>'subject','label'=>'Issue','required'=>true],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Open'=>'Open','In Progress'=>'In Progress','Resolved'=>'Resolved']],
    ],
    'list_sql' => 'SELECT r.*, p.title AS prop, t.name AS tenant FROM requests r
                   LEFT JOIN properties p ON p.id=r.property_id LEFT JOIN tenants t ON t.id=r.tenant_id
                   ORDER BY r.id DESC',
    'columns' => [
        'Issue'   => fn($r) => '<strong>' . h($r['subject']) . '</strong>',
        'Property'=> fn($r) => h($r['prop'] ?? '—'),
        'Raised By'=> fn($r) => h($r['tenant'] ?? '—'),
        'Category'=> fn($r) => h($r['category']),
        'Status'  => fn($r) => status_badge($r['status']),
        'Filed'   => fn($r) => dt($r['created_at']),
    ],
]);
