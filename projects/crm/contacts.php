<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Contact', 'table' => 'contacts',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'name','label'=>'Contact Name','required'=>true],
        ['name'=>'company','label'=>'Company'],
        ['name'=>'email','label'=>'Email','type'=>'email'],
        ['name'=>'phone','label'=>'Phone','type'=>'tel'],
        ['name'=>'source','label'=>'Source','type'=>'select','options'=>['Website'=>'Website','Referral'=>'Referral','Cold Call'=>'Cold Call','LinkedIn'=>'LinkedIn','Expo'=>'Expo','Other'=>'Other']],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Inactive'=>'Inactive']],
    ],
    'columns' => [
        'Name'   => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Company'=> fn($r) => h($r['company']),
        'Email'  => fn($r) => h($r['email']),
        'Phone'  => fn($r) => h($r['phone']),
        'Source' => fn($r) => h($r['source']),
        'Status' => fn($r) => status_badge($r['status']),
    ],
]);
