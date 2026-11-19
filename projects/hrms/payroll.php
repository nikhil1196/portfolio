<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
$emps = ['' => '— Employee —'] + array_column(qa($app, 'SELECT id, name FROM employees ORDER BY name'), 'name', 'id');
crud_page($app, [
    'title' => 'Payroll Entry', 'table' => 'payroll',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'emp_id','label'=>'Employee','type'=>'select','options'=>$emps,'required'=>true],
        ['name'=>'month','label'=>'Month','type'=>'month','required'=>true],
        ['name'=>'basic','label'=>'Basic (₹)','type'=>'number','step'=>'0.01','required'=>true],
        ['name'=>'allowances','label'=>'Allowances (₹)','type'=>'number','step'=>'0.01'],
        ['name'=>'deductions','label'=>'Deductions (₹)','type'=>'number','step'=>'0.01'],
        ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Processed'=>'Processed','Paid'=>'Paid','On Hold'=>'On Hold']],
    ],
    'extra' => fn($p) => ['net' => (float)($p['basic'] ?? 0) + (float)($p['allowances'] ?? 0) - (float)($p['deductions'] ?? 0)],
    'list_sql' => 'SELECT p.*, e.name, e.emp_code FROM payroll p LEFT JOIN employees e ON e.id=p.emp_id ORDER BY p.month DESC, e.name',
    'columns' => [
        'Employee'=> fn($r) => '<strong>' . h($r['name']) . '</strong><br><span class="note">' . h($r['emp_code']) . '</span>',
        'Month'   => fn($r) => h(dt($r['month'] . '-01', 'M Y')),
        'Basic'   => fn($r) => money($r['basic']),
        'Net Pay' => fn($r) => '<strong>' . money($r['net']) . '</strong>',
        'Status'  => fn($r) => status_badge($r['status']),
    ],
]);
