<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$units = ['' => '— Unit —'] + array_column(qa($app, 'SELECT id, flat_no FROM units ORDER BY flat_no'), 'flat_no', 'id');
crud_page($app, [
    'title' => 'Resident', 'table' => 'residents',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'unit_id','label'=>'Unit','type'=>'select','options'=>$units,'required'=>true],
        ['name'=>'name','label'=>'Resident Name','required'=>true],
        ['name'=>'phone','label'=>'Phone','type'=>'tel'],
        ['name'=>'email','label'=>'Email','type'=>'email'],
        ['name'=>'role','label'=>'Role','type'=>'select','options'=>['Owner'=>'Owner','Tenant'=>'Tenant','Family Member'=>'Family Member']],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Moved Out'=>'Moved Out']],
    ],
    'list_sql' => 'SELECT r.*, u.flat_no FROM residents r LEFT JOIN units u ON u.id=r.unit_id ORDER BY r.id DESC',
    'columns' => [
        'Name'  => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Flat'  => fn($r) => h($r['flat_no'] ?? '—'),
        'Role'  => fn($r) => h($r['role']),
        'Phone' => fn($r) => h($r['phone']),
        'Email' => fn($r) => h($r['email']),
        'Status'=> fn($r) => status_badge($r['status']),
    ],
]);
