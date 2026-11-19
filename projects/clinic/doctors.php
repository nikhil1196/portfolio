<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Doctor', 'table' => 'doctors',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'name','label'=>'Doctor Name','required'=>true],
        ['name'=>'specialty','label'=>'Specialty','placeholder'=>'e.g. Cardiology'],
        ['name'=>'phone','label'=>'Phone','type'=>'tel'],
        ['name'=>'fee','label'=>'Consultation Fee (₹)','type'=>'number','step'=>'0.01'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Inactive'=>'Inactive']],
    ],
    'list_sql' => 'SELECT d.*, (SELECT COUNT(*) FROM appointments a WHERE a.doctor_id=d.id) AS appts FROM doctors d ORDER BY d.name',
    'columns' => [
        'Name'     => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Specialty'=> fn($r) => h($r['specialty']),
        'Phone'    => fn($r) => h($r['phone']),
        'Fee'      => fn($r) => money($r['fee']),
        'Appts'    => fn($r) => h($r['appts']),
        'Status'   => fn($r) => status_badge($r['status']),
    ],
]);
