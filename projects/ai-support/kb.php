<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'KB Article', 'table' => 'kb_articles',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'title','label'=>'Article Title','required'=>true],
        ['name'=>'category','label'=>'Category','type'=>'select','options'=>['Billing'=>'Billing','Account'=>'Account','API'=>'API','General'=>'General','Product'=>'Product']],
        ['name'=>'body','label'=>'Content','type'=>'textarea','required'=>true],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Published'=>'Published','Draft'=>'Draft']],
    ],
    'columns' => [
        'Title'   => fn($r) => '<strong>' . h($r['title']) . '</strong>',
        'Category'=> fn($r) => h($r['category']),
        'Views'   => fn($r) => h($r['views']),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
