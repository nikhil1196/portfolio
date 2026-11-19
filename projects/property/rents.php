<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$leases = ['' => '— Lease —'] + array_column(
    qa($app, "SELECT l.id, p.title||' · '||t.name AS n FROM leases l JOIN properties p ON p.id=l.property_id JOIN tenants t ON t.id=l.tenant_id WHERE l.status='Active'"),
    'n', 'id');
crud_page($app, [
    'title' => 'Rent Record', 'table' => 'rents',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'lease_id','label'=>'Lease','type'=>'select','options'=>$leases,'required'=>true],
        ['name'=>'month','label'=>'Month','type'=>'month','required'=>true],
        ['name'=>'amount','label'=>'Amount (₹)','type'=>'number','step'=>'0.01','required'=>true],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Paid'=>'Paid','Due'=>'Due','Overdue'=>'Overdue']],
        ['name'=>'paid_at','label'=>'Paid On','type'=>'date'],
    ],
    'list_sql' => 'SELECT r.*, p.title AS prop, t.name AS tenant FROM rents r
                   JOIN leases l ON l.id=r.lease_id JOIN properties p ON p.id=l.property_id
                   JOIN tenants t ON t.id=l.tenant_id ORDER BY r.month DESC',
    'columns' => [
        'Property'=> fn($r) => '<strong>' . h($r['prop']) . '</strong>',
        'Tenant'  => fn($r) => h($r['tenant']),
        'Month'   => fn($r) => h(dt($r['month'] . '-01', 'M Y')),
        'Amount'  => fn($r) => money($r['amount']),
        'Paid On' => fn($r) => dt($r['paid_at']),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
