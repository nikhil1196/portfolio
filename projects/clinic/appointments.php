<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$patients = ['' => '— Patient —'] + array_column(qa($app, 'SELECT id,name FROM patients ORDER BY name'), 'name', 'id');
$doctors  = ['' => '— Doctor —'] + array_column(qa($app, "SELECT id,name FROM doctors WHERE status='Active' ORDER BY name"), 'name', 'id');
crud_page($app, [
    'title' => 'Appointment', 'table' => 'appointments',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'patient_id','label'=>'Patient','type'=>'select','options'=>$patients,'required'=>true],
        ['name'=>'doctor_id','label'=>'Doctor','type'=>'select','options'=>$doctors,'required'=>true],
        ['name'=>'appt_date','label'=>'Date','type'=>'date','required'=>true],
        ['name'=>'appt_time','label'=>'Time','type'=>'time'],
        ['name'=>'reason','label'=>'Reason / Symptoms'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Scheduled'=>'Scheduled','Completed'=>'Completed','Cancelled'=>'Cancelled']],
    ],
    'list_sql' => 'SELECT a.*, p.name AS patient, d.name AS doctor FROM appointments a
                   LEFT JOIN patients p ON p.id=a.patient_id LEFT JOIN doctors d ON d.id=a.doctor_id
                   ORDER BY a.appt_date DESC, a.appt_time DESC',
    'columns' => [
        'Date'   => fn($r) => dt($r['appt_date']),
        'Time'   => fn($r) => h($r['appt_time']),
        'Patient'=> fn($r) => '<strong>' . h($r['patient']) . '</strong>',
        'Doctor' => fn($r) => h($r['doctor']),
        'Reason' => fn($r) => h($r['reason']),
        'Status' => fn($r) => status_badge($r['status']),
    ],
]);
