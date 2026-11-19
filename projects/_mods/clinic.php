<?php
// Clinic new modules: multi-clinic branches, doctor schedules (availability),
// advance payments with receipt_no.
return [
    'nav' => [
        ['Clinics', 'clinics.index', 'building'],
        ['Schedules', 'schedules.index', 'clock'],
        ['Payments', 'payments.index', 'money'],
    ],
    'modules' => [
        'clinics' => [
            'model' => 'Clinic', 'title' => 'Clinic Branch',
            'columns' => [['name','string'],['address','stringNullable'],['city','stringNullable'],['phone','stringNullable'],['status','statusActive']],
            'fillable' => ['name','address','city','phone','status'],
            'validation' => ['name'=>'required|string|max:255','address'=>'nullable|string','city'=>'nullable|string','phone'=>'nullable|string|max:20','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Clinic Name','text',null,true], ['address','Address','text'],
                ['city','City','text'], ['phone','Phone','tel'],
                ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Clinic' => '<strong>{{ $r->name }}</strong>', 'Address' => '{{ $r->address }}',
                'City' => '{{ $r->city }}', 'Phone' => '{{ $r->phone }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'schedules' => [
            'model' => 'Schedule', 'title' => 'Doctor Schedule',
            'columns' => [['doctor_id','fkreq:Doctor'],['clinic_id','fk:Clinic'],['day','string'],['start_time','time'],['end_time','time'],['slot_min','integer'],['status','statusActive']],
            'fillable' => ['doctor_id','clinic_id','day','start_time','end_time','slot_min','status'],
            'validation' => ['doctor_id'=>'required|exists:doctors,id','clinic_id'=>'nullable|exists:clinics,id','day'=>'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday','start_time'=>'required','end_time'=>'required','slot_min'=>'nullable|integer|min:5','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['doctor_id','Doctor','select','@Doctor',true],
                ['clinic_id','Clinic','select','@Clinic'],
                ['day','Day','select',['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],true],
                ['start_time','From','time',null,true], ['end_time','To','time',null,true],
                ['slot_min','Slot (min)','number'],
                ['status','Status','select',['Active','Inactive']],
            ],
            'with' => ['doctor','clinic'],
            'rels' => ['doctor' => 'belongsTo:Doctor', 'clinic' => 'belongsTo:Clinic'],
            'cols' => [
                'Doctor' => '<strong>{{ $r->doctor->name ?? "—" }}</strong>',
                'Clinic' => '{{ $r->clinic->name ?? "—" }}',
                'Day' => '{{ $r->day }}', 'Hours' => '{{ $r->start_time }} – {{ $r->end_time }}',
                'Slot' => '{{ $r->slot_min }} min', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'payments' => [
            'model' => 'Payment', 'title' => 'Payment',
            'columns' => [['appointment_id','fkreq:Appointment'],['amount','decimal'],['method','default:Cash'],['status','default:Paid'],['receipt_no','stringNullable'],['txn_ref','stringNullable']],
            'fillable' => ['appointment_id','amount','method','status','receipt_no','txn_ref'],
            'validation' => ['appointment_id'=>'required|exists:appointments,id','amount'=>'required|numeric|min:0','method'=>'required|in:Cash,Card,UPI,Stripe','status'=>'required|in:Paid,Pending,Refunded','txn_ref'=>'nullable|string'],
            'fields' => [
                ['appointment_id','Appointment','select','@Appointment:id',true],
                ['amount','Amount (₹)','number',null,true],
                ['method','Method','select',['Cash','Card','UPI','Stripe']],
                ['txn_ref','Transaction Ref','text'],
                ['status','Status','select',['Paid','Pending','Refunded']],
            ],
            'store_extra' => "        \$data['receipt_no'] = 'RCP-' . str_pad((string)(\\App\\Models\\Payment::max('id') + 1001), 4, '0', STR_PAD_LEFT);",
            'with' => ['appointment.patient','appointment.doctor'],
            'rels' => ['appointment' => 'belongsTo:Appointment'],
            'cols' => [
                'Receipt' => '<code>{{ $r->receipt_no }}</code>',
                'Patient' => '<strong>{{ $r->appointment->patient->name ?? "—" }}</strong>',
                'Doctor' => '{{ $r->appointment->doctor->name ?? "—" }}',
                'Amount' => '₹{{ number_format($r->amount) }}', 'Method' => '{{ $r->method }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
    ],
    'seed' => [
        'Clinic' => [
            ['name'=>'HealthFirst Multispeciality','address'=>'12 Ring Road','city'=>'Vadodara','phone'=>'0265-2334455','status'=>'Active'],
            ['name'=>'CarePlus Clinic','address'=>'88 Alkapuri Arcade','city'=>'Vadodara','phone'=>'0265-2445566','status'=>'Active'],
        ],
        'Schedule' => [
            ['doctor_id'=>1,'clinic_id'=>1,'day'=>'Monday','start_time'=>'09:00','end_time'=>'13:00','slot_min'=>20,'status'=>'Active'],
            ['doctor_id'=>1,'clinic_id'=>1,'day'=>'Wednesday','start_time'=>'17:00','end_time'=>'20:00','slot_min'=>20,'status'=>'Active'],
            ['doctor_id'=>2,'clinic_id'=>2,'day'=>'Tuesday','start_time'=>'10:00','end_time'=>'14:00','slot_min'=>30,'status'=>'Active'],
            ['doctor_id'=>2,'clinic_id'=>2,'day'=>'Friday','start_time'=>'10:00','end_time'=>'14:00','slot_min'=>30,'status'=>'Active'],
        ],
        'Payment' => [
            ['appointment_id'=>1,'amount'=>500,'method'=>'Stripe','status'=>'Paid','receipt_no'=>'RCP-1001','txn_ref'=>'txn_demo_8f3k2'],
            ['appointment_id'=>2,'amount'=>300,'method'=>'Cash','status'=>'Paid','receipt_no'=>'RCP-1002','txn_ref'=>null],
        ],
    ],
];
