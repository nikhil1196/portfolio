<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$props   = ['' => '— Property —'] + array_column(qa($app, 'SELECT id,title FROM properties ORDER BY title'), 'title', 'id');
$tenants = ['' => '— Tenant —'] + array_column(qa($app, 'SELECT id,name FROM tenants ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Lease', 'table' => 'leases',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'property_id','label'=>'Property','type'=>'select','options'=>$props,'required'=>true],
        ['name'=>'tenant_id','label'=>'Tenant','type'=>'select','options'=>$tenants,'required'=>true],
        ['name'=>'start_date','label'=>'Start Date','type'=>'date','required'=>true],
        ['name'=>'end_date','label'=>'End Date','type'=>'date','required'=>true],
        ['name'=>'rent','label'=>'Monthly Rent (₹)','type'=>'number','step'=>'0.01','required'=>true],
        ['name'=>'deposit','label'=>'Deposit (₹)','type'=>'number','step'=>'0.01'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Expired'=>'Expired','Terminated'=>'Terminated']],
    ],
    'list_sql' => 'SELECT l.*, p.title AS prop, t.name AS tenant FROM leases l
                   LEFT JOIN properties p ON p.id=l.property_id LEFT JOIN tenants t ON t.id=l.tenant_id
                   ORDER BY l.id DESC',
    'columns' => [
        'Property'=> fn($r) => '<strong>' . h($r['prop']) . '</strong>',
        'Tenant'  => fn($r) => h($r['tenant']),
        'Period'  => fn($r) => dt($r['start_date']) . ' → ' . dt($r['end_date']),
        'Rent'    => fn($r) => money($r['rent']),
        'Deposit' => fn($r) => money($r['deposit']),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
