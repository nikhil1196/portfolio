<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$patients = ['' => '— Patient —'] + array_column(qa($app, 'SELECT id,name FROM patients ORDER BY name'), 'name', 'id');
$doctors  = ['' => '— Doctor —'] + array_column(qa($app, 'SELECT id,name FROM doctors ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Prescription', 'table' => 'prescriptions',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'patient_id','label'=>'Patient','type'=>'select','options'=>$patients,'required'=>true],
        ['name'=>'doctor_id','label'=>'Doctor','type'=>'select','options'=>$doctors,'required'=>true],
        ['name'=>'notes','label'=>'Diagnosis / Notes','type'=>'textarea'],
        ['name'=>'medicines','label'=>'Medicines','type'=>'textarea','placeholder'=>'e.g. Paracetamol 500mg 1-0-1 x 3 days'],
    ],
    'list_sql' => 'SELECT x.*, p.name AS patient, d.name AS doctor FROM prescriptions x
                   LEFT JOIN patients p ON p.id=x.patient_id LEFT JOIN doctors d ON d.id=x.doctor_id
                   ORDER BY x.id DESC',
    'columns' => [
        'Date'     => fn($r) => dt($r['created_at'], 'd M Y'),
        'Patient'  => fn($r) => '<strong>' . h($r['patient']) . '</strong>',
        'Doctor'   => fn($r) => h($r['doctor']),
        'Medicines'=> fn($r) => h(mb_strimwidth($r['medicines'] ?? '', 0, 60, '…')),
        'Notes'    => fn($r) => h(mb_strimwidth($r['notes'] ?? '', 0, 50, '…')),
    ],
]);
