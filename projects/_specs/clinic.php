<?php
return [
    'name' => 'Clinic Management System', 'accent' => '#00b894', 'icon' => '✚',
    'nav' => [
        ['Dashboard', 'dashboard', 'home'], ['Patients', 'patients.index', 'users'],
        ['Doctors', 'doctors.index', 'user'], ['Appointments', 'appointments.index', 'calendar'],
        ['Prescriptions', 'prescriptions.index', 'file'], ['Bills', 'bills.index', 'receipt'],
    ],
    'uses' => "use App\\Models\\Appointment;\nuse App\\Models\\Bill;\nuse App\\Models\\Doctor;\nuse App\\Models\\Patient;",
    'stats' => [
        ['Patients', 'Patient::count()', 'registered'],
        ['Doctors', 'Doctor::count()', 'on staff'],
        ["Today's Appointments", "Appointment::whereDate('appt_date', today())->count()", 'scheduled'],
        ['Revenue (Month)', "'₹'.number_format(Bill::where('status','Paid')->whereMonth('paid_at', now()->month)->whereYear('paid_at', now()->year)->sum('amount'))", 'billed'],
    ],
    'dash' => [
        'title' => "Today's Appointments", 'link' => ['appointments.index', 'All'],
        'query' => "Appointment::with(['patient','doctor'])->whereDate('appt_date', today())->orderBy('appt_time')->get()",
        'cols' => ['Time' => '{{ $r->appt_time }}', 'Patient' => '<strong>{{ $r->patient->name }}</strong>', 'Doctor' => '{{ $r->doctor->name }}', 'Reason' => '{{ $r->reason }}', 'Status' => '<span class="badge">{{ $r->status }}</span>'],
        'empty' => 'Nothing scheduled today',
    ],
    'modules' => [
        'patients' => [
            'model' => 'Patient', 'title' => 'Patient', '_mid' => 1,
            'columns' => [['name','string'],['phone','stringNullable'],['dob','dateNullable'],['gender','stringNullable'],['blood','stringNullable'],['address','textNullable'],['status','statusActive']],
            'fillable' => ['name', 'phone', 'grid','gender', 'blood', 'grid','status'],
            'validation' => ['name'=>'required|string|max:255','phone'=>'nullable|string|max:20','dob'=>'nullable|date','gender'=>'nullable|string','blood'=>'nullable|string|max:5','address'=>'nullable|string','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Full Name','text',null,true], ['phone','Phone','tel'], ['dob','Date of Birth','date'],
                ['gender','Gender','select',['Male','Female','Other']], ['blood','Blood Group','text'],
                ['address','Address','textarea'], ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Name' => '<strong>{{ $r->name }}</strong>', 'Phone' => '{{ $r->phone }}',
                'Gender' => '{{ $r->gender }}', 'Blood' => '{{ $r->blood }}',
                'DOB' => '{{ $r->dob }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'doctors' => [
            'model' => 'Doctor', 'title' => 'Doctor', '_mid' => 2,
            'columns' => [['name','string'],['specialty','stringNullable'],['phone','stringNullable'],['fee','decimal'],['status','statusActive']],
            'fillable' => ['name', 'specialty', 'grid','fee','status'],
            'validation' => ['name'=>'required|string|max:255','specialty'=>'nullable|string','phone'=>'nullable|string|max:20','fee'=>'nullable|numeric|min:0','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Doctor Name','text',null,true], ['specialty','Specialty','text'],
                ['phone','Phone','tel'], ['fee','Consultation Fee (₹)','number'], ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Name' => '<strong>{{ $r->name }}</strong>', 'Specialty' => '{{ $r->specialty }}',
                'Phone' => '{{ $r->phone }}', 'Fee' => '₹{{ number_format($r->fee) }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'appointments' => [
            'model' => 'Appointment', 'title' => 'Appointment', '_mid' => 3,
            'columns' => [['patient_id','fkreq:Patient'],['doctor_id','fkreq:Doctor'],['appt_date','date'],['appt_time','stringNullable'],['reason','stringNullable'],['status','default:Scheduled']],
            'fillable' => ['patient_id','doctor_id','appt_date','appt_time','reason','status'],
            'validation' => ['patient_id'=>'required|exists:patients,id','doctor_id'=>'required|exists:doctors,id','appt_date'=>'required|date','appt_time'=>'nullable','reason'=>'nullable|string','status'=>'required|in:Scheduled,Completed,Cancelled'],
            'fields' => [
                ['patient_id','Patient', 'select', 'grid',true], ['doctor_id','Doctor', 'select', 'grid',true],
                ['appt_date','Date','date',null,true], ['appt_time','Time','time'], ['reason','Reason / Symptoms','text'],
                ['status','Status','select',['Scheduled','Completed','Cancelled']],
            ],
            'with' => ['patient','doctor'],
            'rels' => ['patient' => 'belongsTo:Patient', 'doctor' => 'belongsTo:Doctor'],
            'cols' => [
                'Date' => '{{ $r->appt_date }}', 'Time' => '{{ $r->appt_time }}',
                'Patient' => '<strong>{{ $r->patient->name }}</strong>', 'Doctor' => '{{ $r->doctor->name }}',
                'Reason' => '{{ $r->reason }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'prescriptions' => [
            'model' => 'Prescription', 'title' => 'Prescription', '_mid' => 4,
            'columns' => [['patient_id','fkreq:Patient'],['doctor_id','fkreq:Doctor'],['notes','textNullable'],['medicines','textNullable']],
            'fillable' => ['patient_id','doctor_id','notes','medicines'],
            'validation' => ['patient_id'=>'required|exists:patients,id','doctor_id'=>'required|exists:doctors,id','notes'=>'nullable|string','medicines'=>'nullable|string'],
            'fields' => [
                ['patient_id','Patient', 'select', 'grid',true], ['doctor_id','Doctor', 'select', 'grid',true],
                ['notes','Diagnosis / Notes','textarea'], ['medicines','Medicines','textarea'],
            ],
            'with' => ['patient','doctor'],
            'rels' => ['patient' => 'belongsTo:Patient', 'doctor' => 'belongsTo:Doctor'],
            'cols' => [
                'Date' => '{{ $r->created_at->format(\'d M Y\') }}', 'Patient' => '<strong>{{ $r->patient->name }}</strong>',
                'Doctor' => '{{ $r->doctor->name }}', 'Medicines' => '{{ Str::limit($r->medicines, 60) }}',
                'Notes' => '{{ Str::limit($r->notes, 50) }}',
            ],
        ],
        'bills' => [
            'model' => 'Bill', 'title' => 'Bill', '_mid' => 5,
            'columns' => [['invoice_no','stringNullable'],['patient_id','fkreq:Patient'],['description','stringNullable'],['amount','decimal'],['status','default:Paid'],['paid_at','dateNullable']],
            'fillable' => ['invoice_no','patient_id','description', 'amount', 'grid','paid_at'],
            'validation' => ['patient_id'=>'required|exists:patients,id','description'=>'nullable|string','amount'=>'required|numeric|min:0','status'=>'required|in:Paid,Pending,Cancelled','paid_at'=>'nullable|date'],
            'fields' => [
                ['patient_id','Patient', 'select', 'grid',true], ['description','Description','text'],
                ['amount','Amount (₹)','number',null,true],
                ['status','Status','select',['Paid','Pending','Cancelled']], ['paid_at','Bill Date','date'],
            ],
            'store_extra' => "        \$data['invoice_no'] = 'BILL-' . str_pad((string)(\\App\\Models\\Bill::max('id') + 1001), 4, '0', STR_PAD_LEFT);",
            'with' => ['patient'],
            'rels' => ['patient' => 'belongsTo:Patient'],
            'cols' => [
                'Invoice' => '<code>{{ $r->invoice_no }}</code>', 'Patient' => '<strong>{{ $r->patient->name }}</strong>',
                'For' => '{{ $r->description }}', 'Amount' => '₹{{ number_format($r->amount) }}',
                'Date' => '{{ $r->paid_at }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
    ],
    'seed' => [
        'Doctor' => [
            ['name'=>'Dr. Anita Shah','specialty'=>'General Medicine','phone'=>'9865001101','fee'=>500,'status'=>'Active'],
            ['name'=>'Dr. Rajesh Patel','specialty'=>'Orthopedics','phone'=>'9865001102','fee'=>800,'status'=>'Active'],
            ['name'=>'Dr. Kavita Desai','specialty'=>'Pediatrics','phone'=>'9865001103','fee'=>600,'status'=>'Active'],
            ['name'=>'Dr. Manoj Trivedi','specialty'=>'Dermatology','phone'=>'9865001104','fee'=>700,'status'=>'Active'],
        ],
        'Patient' => [
            ['name'=>'Suresh Kumar','phone'=>'9876100001','dob'=>'1985-04-12','gender'=>'Male','blood'=>'B+','address'=>'Vadodara','status'=>'Active'],
            ['name'=>'Nisha Gandhi','phone'=>'9876100002','dob'=>'1992-08-23','gender'=>'Female','blood'=>'O+','address'=>'Ahmedabad','status'=>'Active'],
            ['name'=>'Farhan Sheikh','phone'=>'9876100003','dob'=>'1978-01-30','gender'=>'Male','blood'=>'AB+','address'=>'Vadodara','status'=>'Active'],
            ['name'=>'Ritu Malhotra','phone'=>'9876100004','dob'=>'2000-11-05','gender'=>'Female','blood'=>'A+','address'=>'Surat','status'=>'Active'],
        ],
        'Appointment' => [
            ['patient_id'=>1,'doctor_id'=>1,'appt_date'=>date('Y-m-d'),'appt_time'=>'10:30','reason'=>'Fever & cold','status'=>'Scheduled'],
            ['patient_id'=>2,'doctor_id'=>4,'appt_date'=>date('Y-m-d'),'appt_time'=>'11:15','reason'=>'Skin rash','status'=>'Scheduled'],
            ['patient_id'=>3,'doctor_id'=>2,'appt_date'=>date('Y-m-d',strtotime('+1 day')),'appt_time'=>'09:45','reason'=>'Knee pain','status'=>'Scheduled'],
        ],
        'Bill' => [
            ['invoice_no'=>'BILL-1001','patient_id'=>1,'description'=>'Consultation','amount'=>500,'status'=>'Paid','paid_at'=>date('Y-m-d')],
            ['invoice_no'=>'BILL-1002','patient_id'=>2,'description'=>'Consultation + Test','amount'=>1500,'status'=>'Pending','paid_at'=>date('Y-m-d')],
        ],
    ],
];
