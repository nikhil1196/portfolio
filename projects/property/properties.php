<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Property', 'table' => 'properties',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'title','label'=>'Property Title','required'=>true],
        ['name'=>'type','label'=>'Type','type'=>'select','options'=>['Apartment'=>'Apartment','Villa'=>'Villa','Studio'=>'Studio','Commercial'=>'Commercial','Shop'=>'Shop','Plot'=>'Plot']],
        ['name'=>'address','label'=>'Address'],
        ['name'=>'city','label'=>'City'],
        ['name'=>'rent','label'=>'Rent (₹/mo)','type'=>'number','step'=>'0.01'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Available'=>'Available','Occupied'=>'Occupied','Maintenance'=>'Maintenance']],
    ],
    'columns' => [
        'Property'=> fn($r) => '<strong>' . h($r['title']) . '</strong>',
        'Type'    => fn($r) => h($r['type']),
        'Location'=> fn($r) => h($r['address'] . ', ' . $r['city']),
        'Rent'    => fn($r) => money($r['rent']),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
