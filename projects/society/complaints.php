<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$residents = ['' => '— Resident —'] + array_column(qa($app, 'SELECT id, name FROM residents ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Complaint', 'table' => 'complaints',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'resident_id','label'=>'Resident','type'=>'select','options'=>$residents,'required'=>true],
        ['name'=>'category','label'=>'Category','type'=>'select','options'=>['Plumbing'=>'Plumbing','Electrical'=>'Electrical','Security'=>'Security','Cleaning'=>'Cleaning','Parking'=>'Parking','Other'=>'Other']],
        ['name'=>'subject','label'=>'Subject','required'=>true],
        ['name'=>'description','label'=>'Description','type'=>'textarea'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Open'=>'Open','In Progress'=>'In Progress','Resolved'=>'Resolved']],
    ],
    'list_sql' => 'SELECT c.*, r.name AS resident, u.flat_no FROM complaints c
                   LEFT JOIN residents r ON r.id=c.resident_id LEFT JOIN units u ON u.id=r.unit_id
                   ORDER BY c.id DESC',
    'columns' => [
        'Flat'    => fn($r) => h($r['flat_no'] ?? '—'),
        'Resident'=> fn($r) => '<strong>' . h($r['resident']) . '</strong>',
        'Subject' => fn($r) => h($r['subject']),
        'Category'=> fn($r) => h($r['category']),
        'Status'  => fn($r) => status_badge($r['status']),
        'Filed'   => fn($r) => dt($r['created_at']),
    ],
]);
