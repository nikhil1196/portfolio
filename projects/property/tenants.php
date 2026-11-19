<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Tenant', 'table' => 'tenants',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'name','label'=>'Tenant Name','required'=>true],
        ['name'=>'phone','label'=>'Phone','type'=>'tel'],
        ['name'=>'email','label'=>'Email','type'=>'email'],
        ['name'=>'id_proof','label'=>'ID Proof','placeholder'=>'e.g. Aadhaar / PAN'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Moved Out'=>'Moved Out']],
    ],
    'list_sql' => "SELECT t.*, p.title AS prop FROM tenants t LEFT JOIN leases l ON l.tenant_id=t.id AND l.status='Active' LEFT JOIN properties p ON p.id=l.property_id ORDER BY t.id DESC",
    'columns' => [
        'Name'    => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Property'=> fn($r) => h($r['prop'] ?? '—'),
        'Phone'   => fn($r) => h($r['phone']),
        'ID Proof'=> fn($r) => h($r['id_proof']),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
