<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Menu Item', 'table' => 'menu_items',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'name','label'=>'Item Name','required'=>true],
        ['name'=>'category','label'=>'Category','type'=>'select','options'=>['Starters'=>'Starters','Breads'=>'Breads','Mains'=>'Mains','South Indian'=>'South Indian','Beverages'=>'Beverages','Desserts'=>'Desserts']],
        ['name'=>'price','label'=>'Price (₹)','type'=>'number','step'=>'0.01','required'=>true],
        ['name'=>'available','label'=>'Available','type'=>'select','options'=>[1=>'Yes',0=>'No']],
    ],
    'list_sql' => 'SELECT * FROM menu_items ORDER BY category, name',
    'columns' => [
        'Item'    => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Category'=> fn($r) => h($r['category']),
        'Price'   => fn($r) => money($r['price']),
        'Available'=> fn($r) => status_badge($r['available'] ? 'Available' : 'Sold Out'),
    ],
]);
