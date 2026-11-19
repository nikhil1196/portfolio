<?php
return [
    'name' => 'HRMS', 'accent' => '#e84393', 'icon' => '◈',
    'nav' => [
        ['Dashboard', 'dashboard', 'home'], ['Departments', 'departments.index', 'briefcase'],
        ['Employees', 'employees.index', 'users'], ['Attendance', 'attendance.index', 'check'],
        ['Leaves', 'leaves.index', 'calendar'], ['Payroll', 'payroll.index', 'money'],
    ],
    'uses' => "use App\\Models\\Department;\nuse App\\Models\\Employee;\nuse App\\Models\\HrAttendance;\nuse App\\Models\\Leave;",
    'stats' => [
        ['Employees', "Employee::where('status','Active')->count()", 'on roll'],
        ['Departments', 'Department::count()', 'teams'],
        ['Present Today', "HrAttendance::whereDate('work_date', today())->where('status','Present')->count()", 'checked in'],
        ['Pending Leaves', "Leave::where('status','Pending')->count()", 'awaiting approval'],
    ],
    'dash' => [
        'title' => "Today's Attendance", 'link' => ['attendance.index', 'Mark'],
        'query' => "HrAttendance::with('employee')->whereDate('work_date', today())->get()",
        'cols' => ['Code' => '<code>{{ $r->employee->emp_code ?? "—" }}</code>', 'Employee' => '<strong>{{ $r->employee->name ?? "—" }}</strong>', 'Check-in' => '{{ $r->check_in ?? "—" }}', 'Status' => '<span class="badge">{{ $r->status }}</span>'],
        'empty' => 'Not marked yet',
    ],
    'modules' => [
        'departments' => [
            'model' => 'Department', 'title' => 'Department', '_mid' => 1,
            'columns' => [['name','string'],['head','stringNullable'],['status','statusActive']],
            'fillable' => ['name','head','status'],
            'validation' => ['name'=>'required|string|max:255','head'=>'nullable|string','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Department Name','text',null,true], ['head','Department Head','text'],
                ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Department' => '<strong>{{ $r->name }}</strong>', 'Head' => '{{ $r->head }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'employees' => [
            'model' => 'Employee', 'title' => 'Employee', '_mid' => 2,
            'columns' => [['emp_code','stringNullable'],['name','string'],['dept_id','fk:Department:dept_id'],['designation','stringNullable'],['email','stringNullable'],['phone','stringNullable'],['joining_date','dateNullable'],['salary','decimal'],['status','statusActive']],
            'fillable' => ['emp_code','name','dept_id','designation','email','phone','joining_date','salary','status'],
            'validation' => ['emp_code'=>'nullable|string|max:15','name'=>'required|string|max:255','dept_id'=>'nullable|exists:departments,id','designation'=>'nullable|string','email'=>'nullable|email','phone'=>'nullable|string|max:20','joining_date'=>'nullable|date','salary'=>'nullable|numeric|min:0','status'=>'required|in:Active,On Notice,Exited'],
            'fields' => [
                ['emp_code','Emp Code','text'], ['name','Full Name','text',null,true],
                ['dept_id','Department','select','@Department'], ['designation','Designation','text'],
                ['email','Email','email'], ['phone','Phone','tel'], ['joining_date','Joining Date','date'],
                ['salary','Salary (₹/mo)','number'], ['status','Status','select',['Active','On Notice','Exited']],
            ],
            'with' => ['department'],
            'rels' => ['department' => 'belongsTo:Department:dept_id'],
            'cols' => [
                'Code' => '<code>{{ $r->emp_code }}</code>', 'Name' => '<strong>{{ $r->name }}</strong><br><span class="note">{{ $r->designation }}</span>',
                'Dept' => '{{ $r->department->name ?? "—" }}', 'Joined' => '{{ $r->joining_date }}',
                'Salary' => '₹{{ number_format($r->salary) }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'attendance' => [
            'model' => 'HrAttendance', 'title' => 'Attendance', 'table' => 'attendances', '_mid' => 3,
            'columns' => [['emp_id','fkreq:Employee:emp_id'],['work_date','date'],['check_in','stringNullable'],['status','default:Present']],
            'fillable' => ['emp_id','work_date','check_in','status'],
            'validation' => ['emp_id'=>'required|exists:employees,id','work_date'=>'required|date','check_in'=>'nullable','status'=>'required|in:Present,Absent,Leave,Half Day,WFH'],
            'fields' => [
                ['emp_id','Employee','select','@Employee',true], ['work_date','Date','date',null,true],
                ['check_in','Check-in Time','time'],
                ['status','Status','select',['Present','Absent','Leave','Half Day','WFH']],
            ],
            'with' => ['employee'],
            'rels' => ['employee' => 'belongsTo:Employee:emp_id'],
            'cols' => [
                'Date' => '{{ $r->work_date }}', 'Employee' => '<strong>{{ $r->employee->name ?? "—" }}</strong><br><span class="note">{{ $r->employee->emp_code ?? "" }}</span>',
                'Check-in' => '{{ $r->check_in ?? "—" }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'leaves' => [
            'model' => 'Leave', 'title' => 'Leave', '_mid' => 4,
            'columns' => [['emp_id','fkreq:Employee:emp_id'],['type','stringNullable'],['from_date','date'],['to_date','date'],['reason','textNullable'],['status','default:Pending']],
            'fillable' => ['emp_id','type','from_date','to_date','reason','status'],
            'validation' => ['emp_id'=>'required|exists:employees,id','type'=>'nullable|string','from_date'=>'required|date','to_date'=>'required|date','reason'=>'nullable|string','status'=>'required|in:Pending,Approved,Rejected'],
            'fields' => [
                ['emp_id','Employee','select','@Employee',true],
                ['type','Leave Type','select',['Casual','Sick','Earned','Unpaid']],
                ['from_date','From','date',null,true], ['to_date','To','date',null,true],
                ['reason','Reason','textarea'],
                ['status','Status','select',['Pending','Approved','Rejected']],
            ],
            'with' => ['employee'],
            'rels' => ['employee' => 'belongsTo:Employee:emp_id'],
            'cols' => [
                'Employee' => '<strong>{{ $r->employee->name ?? "—" }}</strong>', 'Type' => '{{ $r->type }}',
                'From' => '{{ $r->from_date }}', 'To' => '{{ $r->to_date }}',
                'Reason' => '{{ Str::limit($r->reason, 40) }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'payroll' => [
            'model' => 'Payroll', 'title' => 'Payroll Entry', '_mid' => 5,
            'columns' => [['emp_id','fkreq:Employee:emp_id'],['month','stringNullable'],['basic','decimal'],['allowances','decimal'],['deductions','decimal'],['net','decimal'],['status','default:Processed']],
            'fillable' => ['emp_id','month','basic','allowances','deductions','net','status'],
            'validation' => ['emp_id'=>'required|exists:employees,id','month'=>'required|string|max:10','basic'=>'required|numeric','allowances'=>'nullable|numeric','deductions'=>'nullable|numeric','status'=>'required|in:Processed,Paid,On Hold'],
            'fields' => [
                ['emp_id','Employee','select','@Employee',true], ['month','Month','month',null,true],
                ['basic','Basic (₹)','number',null,true], ['allowances','Allowances (₹)','number'],
                ['deductions','Deductions (₹)','number'],
                ['status','Status','select',['Processed','Paid','On Hold']],
            ],
            'store_extra' => "        \$data['net'] = (\$data['basic'] ?? 0) + (\$data['allowances'] ?? 0) - (\$data['deductions'] ?? 0);",
            'with' => ['employee'],
            'rels' => ['employee' => 'belongsTo:Employee:emp_id'],
            'cols' => [
                'Employee' => '<strong>{{ $r->employee->name ?? "—" }}</strong><br><span class="note">{{ $r->employee->emp_code ?? "" }}</span>',
                'Month' => '{{ $r->month }}', 'Basic' => '₹{{ number_format($r->basic) }}',
                'Net Pay' => '<strong>₹{{ number_format($r->net) }}</strong>', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
    ],
    'seed' => [
        'Department' => [
            ['name'=>'Engineering','head'=>'Nikhil Agrawal','status'=>'Active'],
            ['name'=>'HR','head'=>'Priya Sharma','status'=>'Active'],
            ['name'=>'Sales','head'=>'Amit Deshmukh','status'=>'Active'],
            ['name'=>'Finance','head'=>'Ritu Kapoor','status'=>'Active'],
        ],
        'Employee' => [
            ['emp_code'=>'EMP-001','name'=>'Nikhil Agrawal','dept_id'=>1,'designation'=>'Technical Lead','email'=>'nikhil@example.com','phone'=>'9830001001','joining_date'=>'2023-01-02','salary'=>120000,'status'=>'Active'],
            ['emp_code'=>'EMP-002','name'=>'Priya Sharma','dept_id'=>2,'designation'=>'HR Manager','email'=>'priya@example.com','phone'=>'9830001002','joining_date'=>'2021-06-15','salary'=>75000,'status'=>'Active'],
            ['emp_code'=>'EMP-003','name'=>'Amit Deshmukh','dept_id'=>3,'designation'=>'Sales Executive','email'=>'amit.d@example.com','phone'=>'9830001003','joining_date'=>'2022-03-10','salary'=>55000,'status'=>'Active'],
            ['emp_code'=>'EMP-004','name'=>'Ritu Kapoor','dept_id'=>4,'designation'=>'Accountant','email'=>'ritu@example.com','phone'=>'9830001004','joining_date'=>'2020-11-01','salary'=>60000,'status'=>'Active'],
            ['emp_code'=>'EMP-005','name'=>'Vikas Yadav','dept_id'=>1,'designation'=>'Backend Developer','email'=>'vikas@example.com','phone'=>'9830001005','joining_date'=>'2024-02-19','salary'=>65000,'status'=>'Active'],
        ],
        'HrAttendance' => [
            ['emp_id'=>1,'work_date'=>date('Y-m-d'),'check_in'=>'09:15','status'=>'Present'],
            ['emp_id'=>2,'work_date'=>date('Y-m-d'),'check_in'=>'09:30','status'=>'Present'],
            ['emp_id'=>3,'work_date'=>date('Y-m-d'),'check_in'=>null,'status'=>'Leave'],
            ['emp_id'=>4,'work_date'=>date('Y-m-d'),'check_in'=>'09:05','status'=>'Present'],
        ],
        'Leave' => [
            ['emp_id'=>3,'type'=>'Casual','from_date'=>date('Y-m-d'),'to_date'=>date('Y-m-d',strtotime('+1 day')),'reason'=>'Family function','status'=>'Approved'],
            ['emp_id'=>5,'type'=>'Sick','from_date'=>date('Y-m-d',strtotime('+5 day')),'to_date'=>date('Y-m-d',strtotime('+6 day')),'reason'=>'Doctor advised rest','status'=>'Pending'],
        ],
        'Payroll' => [
            ['emp_id'=>1,'month'=>'2026-10','basic'=>120000,'allowances'=>18000,'deductions'=>5000,'net'=>133000,'status'=>'Paid'],
            ['emp_id'=>2,'month'=>'2026-10','basic'=>75000,'allowances'=>10000,'deductions'=>3000,'net'=>82000,'status'=>'Paid'],
        ],
    ],
];
