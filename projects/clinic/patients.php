<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
crud_page($app, [
    'title' => 'Patient', 'table' => 'patients',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'name','label'=>'Full Name','required'=>true],
        ['name'=>'phone','label'=>'Phone','type'=>'tel'],
        ['name'=>'dob','label'=>'Date of Birth','type'=>'date'],
        ['name'=>'gender','label'=>'Gender','type'=>'select','options'=>['Male'=>'Male','Female'=>'Female','Other'=>'Other']],
        ['name'=>'blood','label'=>'Blood Group','placeholder'=>'e.g. B+'],
        ['name'=>'address','label'=>'Address','type'=>'textarea'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Inactive'=>'Inactive']],
    ],
    'columns' => [
        'Name'  => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Phone' => fn($r) => h($r['phone']),
        'Gender'=> fn($r) => h($r['gender']),
        'Blood' => fn($r) => h($r['blood']),
        'DOB'   => fn($r) => dt($r['dob']),
        'Status'=> fn($r) => status_badge($r['status']),
    ],
]);
