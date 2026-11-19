<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$patients = ['' => '— Patient —'] + array_column(qa($app, 'SELECT id,name FROM patients ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Bill', 'table' => 'bills',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'patient_id','label'=>'Patient','type'=>'select','options'=>$patients,'required'=>true],
        ['name'=>'description','label'=>'Description','placeholder'=>'e.g. Consultation + Lab test'],
        ['name'=>'amount','label'=>'Amount (₹)','type'=>'number','step'=>'0.01','required'=>true],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Paid'=>'Paid','Pending'=>'Pending','Cancelled'=>'Cancelled']],
        ['name'=>'paid_at','label'=>'Bill Date','type'=>'date'],
    ],
    'extra' => fn($p) => $p['id'] ? [] : ['invoice_no' => 'BILL-' . str_pad((string)(qv($app, 'SELECT COALESCE(MAX(id),0) FROM bills') + 1001), 4, '0', STR_PAD_LEFT)],
    'list_sql' => 'SELECT b.*, p.name AS patient FROM bills b LEFT JOIN patients p ON p.id=b.patient_id ORDER BY b.id DESC',
    'columns' => [
        'Invoice' => fn($r) => '<code>' . h($r['invoice_no']) . '</code>',
        'Patient' => fn($r) => '<strong>' . h($r['patient']) . '</strong>',
        'For'     => fn($r) => h($r['description']),
        'Amount'  => fn($r) => money($r['amount']),
        'Date'    => fn($r) => dt($r['paid_at']),
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
