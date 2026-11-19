<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Unit', 'table' => 'units',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'block','label'=>'Block','placeholder'=>'e.g. A'],
        ['name'=>'flat_no','label'=>'Flat No','required'=>true,'placeholder'=>'e.g. A-101'],
        ['name'=>'floor','label'=>'Floor','type'=>'number'],
        ['name'=>'type','label'=>'Type','type'=>'select','options'=>['1 BHK'=>'1 BHK','2 BHK'=>'2 BHK','3 BHK'=>'3 BHK','Shop'=>'Shop']],
        ['name'=>'area_sqft','label'=>'Area (sq.ft)','type'=>'number'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Occupied'=>'Occupied','Vacant'=>'Vacant']],
    ],
    'list_sql' => 'SELECT u.*, (SELECT COUNT(*) FROM residents r WHERE r.unit_id=u.id) AS residents FROM units u ORDER BY u.block, u.flat_no',
    'columns' => [
        'Flat'     => fn($r) => '<strong>' . h($r['flat_no']) . '</strong>',
        'Block'    => fn($r) => h($r['block']),
        'Type'     => fn($r) => h($r['type']),
        'Area'     => fn($r) => h($r['area_sqft']) . ' sq.ft',
        'Residents'=> fn($r) => h($r['residents']),
        'Status'   => fn($r) => status_badge($r['status']),
    ],
]);
