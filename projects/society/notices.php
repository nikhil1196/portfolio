<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Notice', 'table' => 'notices',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'title','label'=>'Title','required'=>true],
        ['name'=>'body','label'=>'Notice Text','type'=>'textarea','required'=>true],
        ['name'=>'audience','label'=>'Audience','type'=>'select','options'=>['All'=>'All','Owners'=>'Owners','Tenants'=>'Tenants']],
        ['name'=>'published_at','label'=>'Publish Date','type'=>'date'],
    ],
    'columns' => [
        'Title'    => fn($r) => '<strong>' . h($r['title']) . '</strong>',
        'Notice'   => fn($r) => h(mb_strimwidth($r['body'] ?? '', 0, 80, '…')),
        'Audience' => fn($r) => h($r['audience']),
        'Published'=> fn($r) => dt($r['published_at']),
    ],
]);
