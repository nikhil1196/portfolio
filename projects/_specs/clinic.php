<?php
return array (
  'name' => 'Clinic Management System',
  'accent' => '#00b894',
  'icon' => '✚',
  'nav' => 
  array (
    0 => 
    array (
      0 => 'Dashboard',
      1 => 'dashboard',
      2 => 'home',
    ),
    1 => 
    array (
      0 => 'Patients',
      1 => 'patients.index',
      2 => 'users',
    ),
    2 => 
    array (
      0 => 'Doctors',
      1 => 'doctors.index',
      2 => 'user',
    ),
    3 => 
    array (
      0 => 'Appointments',
      1 => 'appointments.index',
      2 => 'calendar',
    ),
    4 => 
    array (
      0 => 'Prescriptions',
      1 => 'prescriptions.index',
      2 => 'file',
    ),
    5 => 
    array (
      0 => 'Bills',
      1 => 'bills.index',
      2 => 'receipt',
    ),
  ),
  'uses' => 'use App\\Models\\Appointment;
use App\\Models\\Bill;
use App\\Models\\Doctor;
use App\\Models\\Patient;',
  'stats' => 
  array (
    0 => 
    array (
      0 => 'Patients',
      1 => 'Patient::count()',
      2 => 'registered',
    ),
    1 => 
    array (
      0 => 'Doctors',
      1 => 'Doctor::count()',
      2 => 'on staff',
    ),
    2 => 
    array (
      0 => 'Today\'s Appointments',
      1 => 'Appointment::whereDate(\'appt_date\', today())->count()',
      2 => 'scheduled',
    ),
    3 => 
    array (
      0 => 'Revenue (Month)',
      1 => '\'₹\'.number_format(Bill::where(\'status\',\'Paid\')->whereMonth(\'paid_at\', now()->month)->whereYear(\'paid_at\', now()->year)->sum(\'amount\'))',
      2 => 'billed',
    ),
  ),
  'dash' => 
  array (
    'title' => 'Today\'s Appointments',
    'link' => 
    array (
      0 => 'appointments.index',
      1 => 'All',
    ),
    'query' => 'Appointment::with([\'patient\',\'doctor\'])->whereDate(\'appt_date\', today())->orderBy(\'appt_time\')->get()',
    'cols' => 
    array (
      'Time' => '{{ $r->appt_time }}',
      'Patient' => '<strong>{{ $r->patient->name }}</strong>',
      'Doctor' => '{{ $r->doctor->name }}',
      'Reason' => '{{ $r->reason }}',
      'Status' => '<span class="badge">{{ $r->status }}</span>',
    ),
    'empty' => 'Nothing scheduled today',
  ),
  'modules' => 
  array (
    'patients' => 
    array (
      'model' => 'Patient',
      'title' => 'Patient',
      '_mid' => 1,
      'columns' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'string',
        ),
        1 => 
        array (
          0 => 'phone',
          1 => 'stringNullable',
        ),
        2 => 
        array (
          0 => 'dob',
          1 => 'dateNullable',
        ),
        3 => 
        array (
          0 => 'gender',
          1 => 'stringNullable',
        ),
        4 => 
        array (
          0 => 'blood',
          1 => 'stringNullable',
        ),
        5 => 
        array (
          0 => 'address',
          1 => 'textNullable',
        ),
        6 => 
        array (
          0 => 'status',
          1 => 'statusActive',
        ),
      ),
      'fillable' => 
      array (
        0 => 'name',
        1 => 'phone',
        2 => 'dob',
        3 => 'gender',
        4 => 'blood',
        5 => 'address',
        6 => 'status',
      ),
      'validation' => 
      array (
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'dob' => 'nullable|date',
        'gender' => 'nullable|string',
        'blood' => 'nullable|string|max:5',
        'address' => 'nullable|string',
        'status' => 'required|in:Active,Inactive',
      ),
      'fields' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'Full Name',
          2 => 'text',
          3 => NULL,
          4 => true,
        ),
        1 => 
        array (
          0 => 'phone',
          1 => 'Phone',
          2 => 'tel',
        ),
        2 => 
        array (
          0 => 'dob',
          1 => 'Date of Birth',
          2 => 'date',
        ),
        3 => 
        array (
          0 => 'gender',
          1 => 'Gender',
          2 => 'select',
          3 => 
          array (
            0 => 'Male',
            1 => 'Female',
            2 => 'Other',
          ),
        ),
        4 => 
        array (
          0 => 'blood',
          1 => 'Blood Group',
          2 => 'text',
        ),
        5 => 
        array (
          0 => 'address',
          1 => 'Address',
          2 => 'textarea',
        ),
        6 => 
        array (
          0 => 'status',
          1 => 'Status',
          2 => 'select',
          3 => 
          array (
            0 => 'Active',
            1 => 'Inactive',
          ),
        ),
      ),
      'cols' => 
      array (
        'Name' => '<strong>{{ $r->name }}</strong>',
        'Phone' => '{{ $r->phone }}',
        'Gender' => '{{ $r->gender }}',
        'Blood' => '{{ $r->blood }}',
        'DOB' => '{{ $r->dob }}',
        'Status' => '<span class="badge">{{ $r->status }}</span>',
      ),
    ),
    'doctors' => 
    array (
      'model' => 'Doctor',
      'title' => 'Doctor',
      '_mid' => 2,
      'columns' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'string',
        ),
        1 => 
        array (
          0 => 'specialty',
          1 => 'stringNullable',
        ),
        2 => 
        array (
          0 => 'phone',
          1 => 'stringNullable',
        ),
        3 => 
        array (
          0 => 'email',
          1 => 'stringNullable',
        ),
        4 => 
        array (
          0 => 'fee',
          1 => 'decimal',
        ),
        5 => 
        array (
          0 => 'clinic_id',
          1 => 'fk:Clinic',
        ),
        6 => 
        array (
          0 => 'status',
          1 => 'statusActive',
        ),
      ),
      'fillable' => 
      array (
        0 => 'name',
        1 => 'specialty',
        2 => 'phone',
        3 => 'email',
        4 => 'fee',
        5 => 'clinic_id',
        6 => 'status',
      ),
      'validation' => 
      array (
        'name' => 'required|string|max:255',
        'specialty' => 'nullable|string',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email',
        'fee' => 'nullable|numeric|min:0',
        'clinic_id' => 'nullable|exists:clinics,id',
        'status' => 'required|in:Active,Inactive',
      ),
      'fields' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'Doctor Name',
          2 => 'text',
          3 => NULL,
          4 => true,
        ),
        1 => 
        array (
          0 => 'specialty',
          1 => 'Specialty',
          2 => 'text',
        ),
        2 => 
        array (
          0 => 'clinic_id',
          1 => 'Clinic',
          2 => 'select',
          3 => '@Clinic',
        ),
        3 => 
        array (
          0 => 'email',
          1 => 'Email',
          2 => 'email',
        ),
        4 => 
        array (
          0 => 'phone',
          1 => 'Phone',
          2 => 'tel',
        ),
        5 => 
        array (
          0 => 'fee',
          1 => 'Consultation Fee (₹)',
          2 => 'number',
        ),
        6 => 
        array (
          0 => 'status',
          1 => 'Status',
          2 => 'select',
          3 => 
          array (
            0 => 'Active',
            1 => 'Inactive',
          ),
        ),
      ),
      'with' => 
      array (
        0 => 'clinic',
      ),
      'rels' => 
      array (
        'clinic' => 'belongsTo:Clinic',
      ),
      'cols' => 
      array (
        'Name' => '<strong>{{ $r->name }}</strong>',
        'Specialty' => '{{ $r->specialty }}',
        'Clinic' => '{{ $r->clinic->name ?? "—" }}',
        'Phone' => '{{ $r->phone }}',
        'Fee' => '₹{{ number_format($r->fee) }}',
        'Status' => '<span class="badge">{{ $r->status }}</span>',
      ),
    ),
    'appointments' => 
    array (
      'model' => 'Appointment',
      'title' => 'Appointment',
      '_mid' => 3,
      'columns' => 
      array (
        0 => 
        array (
          0 => 'patient_id',
          1 => 'fkreq:Patient',
        ),
        1 => 
        array (
          0 => 'doctor_id',
          1 => 'fkreq:Doctor',
        ),
        2 => 
        array (
          0 => 'clinic_id',
          1 => 'fk:Clinic',
        ),
        3 => 
        array (
          0 => 'appt_date',
          1 => 'date',
        ),
        4 => 
        array (
          0 => 'appt_time',
          1 => 'stringNullable',
        ),
        5 => 
        array (
          0 => 'reason',
          1 => 'stringNullable',
        ),
        6 => 
        array (
          0 => 'status',
          1 => 'default:Scheduled',
        ),
      ),
      'fillable' => 
      array (
        0 => 'patient_id',
        1 => 'doctor_id',
        2 => 'clinic_id',
        3 => 'appt_date',
        4 => 'appt_time',
        5 => 'reason',
        6 => 'status',
      ),
      'validation' => 
      array (
        'patient_id' => 'required|exists:patients,id',
        'doctor_id' => 'required|exists:doctors,id',
        'clinic_id' => 'nullable|exists:clinics,id',
        'appt_date' => 'required|date',
        'appt_time' => 'nullable',
        'reason' => 'nullable|string',
        'status' => 'required|in:Scheduled,Completed,Cancelled',
      ),
      'fields' => 
      array (
        0 => 
        array (
          0 => 'patient_id',
          1 => 'Patient',
          2 => 'select',
          3 => '@Patient',
          4 => true,
        ),
        1 => 
        array (
          0 => 'doctor_id',
          1 => 'Doctor',
          2 => 'select',
          3 => '@Doctor',
          4 => true,
        ),
        2 => 
        array (
          0 => 'clinic_id',
          1 => 'Clinic',
          2 => 'select',
          3 => '@Clinic',
        ),
        3 => 
        array (
          0 => 'appt_date',
          1 => 'Date',
          2 => 'date',
          3 => NULL,
          4 => true,
        ),
        4 => 
        array (
          0 => 'appt_time',
          1 => 'Time',
          2 => 'time',
        ),
        5 => 
        array (
          0 => 'reason',
          1 => 'Reason / Symptoms',
          2 => 'text',
        ),
        6 => 
        array (
          0 => 'status',
          1 => 'Status',
          2 => 'select',
          3 => 
          array (
            0 => 'Scheduled',
            1 => 'Completed',
            2 => 'Cancelled',
          ),
        ),
      ),
      'with' => 
      array (
        0 => 'patient',
        1 => 'doctor',
        2 => 'clinic',
      ),
      'rels' => 
      array (
        'patient' => 'belongsTo:Patient',
        'doctor' => 'belongsTo:Doctor',
        'clinic' => 'belongsTo:Clinic',
      ),
      'cols' => 
      array (
        'Date' => '{{ $r->appt_date }}',
        'Time' => '{{ $r->appt_time }}',
        'Patient' => '<strong>{{ $r->patient->name }}</strong>',
        'Doctor' => '{{ $r->doctor->name }}',
        'Clinic' => '{{ $r->clinic->name ?? "—" }}',
        'Reason' => '{{ $r->reason }}',
        'Status' => '<span class="badge">{{ $r->status }}</span>',
      ),
    ),
    'prescriptions' => 
    array (
      'model' => 'Prescription',
      'title' => 'Prescription',
      '_mid' => 4,
      'columns' => 
      array (
        0 => 
        array (
          0 => 'patient_id',
          1 => 'fkreq:Patient',
        ),
        1 => 
        array (
          0 => 'doctor_id',
          1 => 'fkreq:Doctor',
        ),
        2 => 
        array (
          0 => 'notes',
          1 => 'textNullable',
        ),
        3 => 
        array (
          0 => 'medicines',
          1 => 'textNullable',
        ),
      ),
      'fillable' => 
      array (
        0 => 'patient_id',
        1 => 'doctor_id',
        2 => 'notes',
        3 => 'medicines',
      ),
      'validation' => 
      array (
        'patient_id' => 'required|exists:patients,id',
        'doctor_id' => 'required|exists:doctors,id',
        'notes' => 'nullable|string',
        'medicines' => 'nullable|string',
      ),
      'fields' => 
      array (
        0 => 
        array (
          0 => 'patient_id',
          1 => 'Patient',
          2 => 'select',
          3 => '@Patient',
          4 => true,
        ),
        1 => 
        array (
          0 => 'doctor_id',
          1 => 'Doctor',
          2 => 'select',
          3 => '@Doctor',
          4 => true,
        ),
        2 => 
        array (
          0 => 'notes',
          1 => 'Diagnosis / Notes',
          2 => 'textarea',
        ),
        3 => 
        array (
          0 => 'medicines',
          1 => 'Medicines',
          2 => 'textarea',
        ),
      ),
      'with' => 
      array (
        0 => 'patient',
        1 => 'doctor',
      ),
      'rels' => 
      array (
        'patient' => 'belongsTo:Patient',
        'doctor' => 'belongsTo:Doctor',
      ),
      'cols' => 
      array (
        'Date' => '{{ $r->created_at->format(\'d M Y\') }}',
        'Patient' => '<strong>{{ $r->patient->name }}</strong>',
        'Doctor' => '{{ $r->doctor->name }}',
        'Medicines' => '{{ Str::limit($r->medicines, 60) }}',
        'Notes' => '{{ Str::limit($r->notes, 50) }}',
      ),
    ),
    'bills' => 
    array (
      'model' => 'Bill',
      'title' => 'Bill',
      '_mid' => 5,
      'columns' => 
      array (
        0 => 
        array (
          0 => 'invoice_no',
          1 => 'stringNullable',
        ),
        1 => 
        array (
          0 => 'patient_id',
          1 => 'fkreq:Patient',
        ),
        2 => 
        array (
          0 => 'description',
          1 => 'stringNullable',
        ),
        3 => 
        array (
          0 => 'amount',
          1 => 'decimal',
        ),
        4 => 
        array (
          0 => 'status',
          1 => 'default:Paid',
        ),
        5 => 
        array (
          0 => 'paid_at',
          1 => 'dateNullable',
        ),
      ),
      'fillable' => 
      array (
        0 => 'invoice_no',
        1 => 'patient_id',
        2 => 'description',
        3 => 'amount',
        4 => 'status',
        5 => 'paid_at',
      ),
      'validation' => 
      array (
        'patient_id' => 'required|exists:patients,id',
        'description' => 'nullable|string',
        'amount' => 'required|numeric|min:0',
        'status' => 'required|in:Paid,Pending,Cancelled',
        'paid_at' => 'nullable|date',
      ),
      'fields' => 
      array (
        0 => 
        array (
          0 => 'patient_id',
          1 => 'Patient',
          2 => 'select',
          3 => '@Patient',
          4 => true,
        ),
        1 => 
        array (
          0 => 'description',
          1 => 'Description',
          2 => 'text',
        ),
        2 => 
        array (
          0 => 'amount',
          1 => 'Amount (₹)',
          2 => 'number',
          3 => NULL,
          4 => true,
        ),
        3 => 
        array (
          0 => 'status',
          1 => 'Status',
          2 => 'select',
          3 => 
          array (
            0 => 'Paid',
            1 => 'Pending',
            2 => 'Cancelled',
          ),
        ),
        4 => 
        array (
          0 => 'paid_at',
          1 => 'Bill Date',
          2 => 'date',
        ),
      ),
      'store_extra' => '        $data[\'invoice_no\'] = \'BILL-\' . str_pad((string)(\\App\\Models\\Bill::max(\'id\') + 1001), 4, \'0\', STR_PAD_LEFT);',
      'with' => 
      array (
        0 => 'patient',
      ),
      'rels' => 
      array (
        'patient' => 'belongsTo:Patient',
      ),
      'cols' => 
      array (
        'Invoice' => '<code>{{ $r->invoice_no }}</code>',
        'Patient' => '<strong>{{ $r->patient->name }}</strong>',
        'For' => '{{ $r->description }}',
        'Amount' => '₹{{ number_format($r->amount) }}',
        'Date' => '{{ $r->paid_at }}',
        'Status' => '<span class="badge">{{ $r->status }}</span>',
      ),
    ),
    'clinics' => 
    array (
      'model' => 'Clinic',
      'title' => 'Clinic Branch',
      'columns' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'string',
        ),
        1 => 
        array (
          0 => 'address',
          1 => 'stringNullable',
        ),
        2 => 
        array (
          0 => 'city',
          1 => 'stringNullable',
        ),
        3 => 
        array (
          0 => 'phone',
          1 => 'stringNullable',
        ),
        4 => 
        array (
          0 => 'status',
          1 => 'statusActive',
        ),
      ),
      'fillable' => 
      array (
        0 => 'name',
        1 => 'address',
        2 => 'city',
        3 => 'phone',
        4 => 'status',
      ),
      'validation' => 
      array (
        'name' => 'required|string|max:255',
        'address' => 'nullable|string',
        'city' => 'nullable|string',
        'phone' => 'nullable|string|max:20',
        'status' => 'required|in:Active,Inactive',
      ),
      'fields' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'Clinic Name',
          2 => 'text',
          3 => NULL,
          4 => true,
        ),
        1 => 
        array (
          0 => 'address',
          1 => 'Address',
          2 => 'text',
        ),
        2 => 
        array (
          0 => 'city',
          1 => 'City',
          2 => 'text',
        ),
        3 => 
        array (
          0 => 'phone',
          1 => 'Phone',
          2 => 'tel',
        ),
        4 => 
        array (
          0 => 'status',
          1 => 'Status',
          2 => 'select',
          3 => 
          array (
            0 => 'Active',
            1 => 'Inactive',
          ),
        ),
      ),
      'cols' => 
      array (
        'Clinic' => '<strong>{{ $r->name }}</strong>',
        'Address' => '{{ $r->address }}',
        'City' => '{{ $r->city }}',
        'Phone' => '{{ $r->phone }}',
        'Status' => '<span class="badge">{{ $r->status }}</span>',
      ),
      '_mid' => 6,
    ),
    'schedules' => 
    array (
      'model' => 'Schedule',
      'title' => 'Doctor Schedule',
      'columns' => 
      array (
        0 => 
        array (
          0 => 'doctor_id',
          1 => 'fkreq:Doctor',
        ),
        1 => 
        array (
          0 => 'clinic_id',
          1 => 'fk:Clinic',
        ),
        2 => 
        array (
          0 => 'day',
          1 => 'string',
        ),
        3 => 
        array (
          0 => 'start_time',
          1 => 'time',
        ),
        4 => 
        array (
          0 => 'end_time',
          1 => 'time',
        ),
        5 => 
        array (
          0 => 'slot_min',
          1 => 'integer',
        ),
        6 => 
        array (
          0 => 'status',
          1 => 'statusActive',
        ),
      ),
      'fillable' => 
      array (
        0 => 'doctor_id',
        1 => 'clinic_id',
        2 => 'day',
        3 => 'start_time',
        4 => 'end_time',
        5 => 'slot_min',
        6 => 'status',
      ),
      'validation' => 
      array (
        'doctor_id' => 'required|exists:doctors,id',
        'clinic_id' => 'nullable|exists:clinics,id',
        'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
        'start_time' => 'required',
        'end_time' => 'required',
        'slot_min' => 'nullable|integer|min:5',
        'status' => 'required|in:Active,Inactive',
      ),
      'fields' => 
      array (
        0 => 
        array (
          0 => 'doctor_id',
          1 => 'Doctor',
          2 => 'select',
          3 => '@Doctor',
          4 => true,
        ),
        1 => 
        array (
          0 => 'clinic_id',
          1 => 'Clinic',
          2 => 'select',
          3 => '@Clinic',
        ),
        2 => 
        array (
          0 => 'day',
          1 => 'Day',
          2 => 'select',
          3 => 
          array (
            0 => 'Monday',
            1 => 'Tuesday',
            2 => 'Wednesday',
            3 => 'Thursday',
            4 => 'Friday',
            5 => 'Saturday',
            6 => 'Sunday',
          ),
          4 => true,
        ),
        3 => 
        array (
          0 => 'start_time',
          1 => 'From',
          2 => 'time',
          3 => NULL,
          4 => true,
        ),
        4 => 
        array (
          0 => 'end_time',
          1 => 'To',
          2 => 'time',
          3 => NULL,
          4 => true,
        ),
        5 => 
        array (
          0 => 'slot_min',
          1 => 'Slot (min)',
          2 => 'number',
        ),
        6 => 
        array (
          0 => 'status',
          1 => 'Status',
          2 => 'select',
          3 => 
          array (
            0 => 'Active',
            1 => 'Inactive',
          ),
        ),
      ),
      'with' => 
      array (
        0 => 'doctor',
        1 => 'clinic',
      ),
      'rels' => 
      array (
        'doctor' => 'belongsTo:Doctor',
        'clinic' => 'belongsTo:Clinic',
      ),
      'cols' => 
      array (
        'Doctor' => '<strong>{{ $r->doctor->name ?? "—" }}</strong>',
        'Clinic' => '{{ $r->clinic->name ?? "—" }}',
        'Day' => '{{ $r->day }}',
        'Hours' => '{{ $r->start_time }} – {{ $r->end_time }}',
        'Slot' => '{{ $r->slot_min }} min',
        'Status' => '<span class="badge">{{ $r->status }}</span>',
      ),
      '_mid' => 7,
    ),
    'payments' => 
    array (
      'model' => 'Payment',
      'title' => 'Payment',
      'columns' => 
      array (
        0 => 
        array (
          0 => 'appointment_id',
          1 => 'fkreq:Appointment',
        ),
        1 => 
        array (
          0 => 'amount',
          1 => 'decimal',
        ),
        2 => 
        array (
          0 => 'method',
          1 => 'default:Cash',
        ),
        3 => 
        array (
          0 => 'status',
          1 => 'default:Paid',
        ),
        4 => 
        array (
          0 => 'receipt_no',
          1 => 'stringNullable',
        ),
        5 => 
        array (
          0 => 'txn_ref',
          1 => 'stringNullable',
        ),
      ),
      'fillable' => 
      array (
        0 => 'appointment_id',
        1 => 'amount',
        2 => 'method',
        3 => 'status',
        4 => 'receipt_no',
        5 => 'txn_ref',
      ),
      'validation' => 
      array (
        'appointment_id' => 'required|exists:appointments,id',
        'amount' => 'required|numeric|min:0',
        'method' => 'required|in:Cash,Card,UPI,Stripe',
        'status' => 'required|in:Paid,Pending,Refunded',
        'txn_ref' => 'nullable|string',
      ),
      'fields' => 
      array (
        0 => 
        array (
          0 => 'appointment_id',
          1 => 'Appointment',
          2 => 'select',
          3 => '@Appointment:id',
          4 => true,
        ),
        1 => 
        array (
          0 => 'amount',
          1 => 'Amount (₹)',
          2 => 'number',
          3 => NULL,
          4 => true,
        ),
        2 => 
        array (
          0 => 'method',
          1 => 'Method',
          2 => 'select',
          3 => 
          array (
            0 => 'Cash',
            1 => 'Card',
            2 => 'UPI',
            3 => 'Stripe',
          ),
        ),
        3 => 
        array (
          0 => 'txn_ref',
          1 => 'Transaction Ref',
          2 => 'text',
        ),
        4 => 
        array (
          0 => 'status',
          1 => 'Status',
          2 => 'select',
          3 => 
          array (
            0 => 'Paid',
            1 => 'Pending',
            2 => 'Refunded',
          ),
        ),
      ),
      'store_extra' => '        $data[\'receipt_no\'] = \'RCP-\' . str_pad((string)(\\App\\Models\\Payment::max(\'id\') + 1001), 4, \'0\', STR_PAD_LEFT);',
      'with' => 
      array (
        0 => 'appointment.patient',
        1 => 'appointment.doctor',
      ),
      'rels' => 
      array (
        'appointment' => 'belongsTo:Appointment',
      ),
      'cols' => 
      array (
        'Receipt' => '<code>{{ $r->receipt_no }}</code>',
        'Patient' => '<strong>{{ $r->appointment->patient->name ?? "—" }}</strong>',
        'Doctor' => '{{ $r->appointment->doctor->name ?? "—" }}',
        'Amount' => '₹{{ number_format($r->amount) }}',
        'Method' => '{{ $r->method }}',
        'Status' => '<span class="badge">{{ $r->status }}</span>',
      ),
      '_mid' => 8,
    ),
  ),
  'seed' => 
  array (
    'Clinic' => 
    array (
      0 => 
      array (
        'name' => 'HealthFirst Multispeciality',
        'address' => '12 Ring Road',
        'city' => 'Vadodara',
        'phone' => '0265-2334455',
        'status' => 'Active',
      ),
      1 => 
      array (
        'name' => 'CarePlus Clinic',
        'address' => '88 Alkapuri Arcade',
        'city' => 'Vadodara',
        'phone' => '0265-2445566',
        'status' => 'Active',
      ),
    ),
    'Patient' => 
    array (
      0 => 
      array (
        'name' => 'Suresh Kumar',
        'phone' => '9876100001',
        'dob' => '1985-04-12',
        'gender' => 'Male',
        'blood' => 'B+',
        'address' => 'Vadodara',
        'status' => 'Active',
      ),
      1 => 
      array (
        'name' => 'Nisha Gandhi',
        'phone' => '9876100002',
        'dob' => '1992-08-23',
        'gender' => 'Female',
        'blood' => 'O+',
        'address' => 'Ahmedabad',
        'status' => 'Active',
      ),
      2 => 
      array (
        'name' => 'Farhan Sheikh',
        'phone' => '9876100003',
        'dob' => '1978-01-30',
        'gender' => 'Male',
        'blood' => 'AB+',
        'address' => 'Vadodara',
        'status' => 'Active',
      ),
      3 => 
      array (
        'name' => 'Ritu Malhotra',
        'phone' => '9876100004',
        'dob' => '2000-11-05',
        'gender' => 'Female',
        'blood' => 'A+',
        'address' => 'Surat',
        'status' => 'Active',
      ),
    ),
    'Doctor' => 
    array (
      0 => 
      array (
        'name' => 'Dr. Anita Shah',
        'specialty' => 'General Medicine',
        'phone' => '9865001101',
        'fee' => 500,
        'status' => 'Active',
        'email' => 'anita.shah@clinic.demo',
        'clinic_id' => 1,
      ),
      1 => 
      array (
        'name' => 'Dr. Rajesh Patel',
        'specialty' => 'Orthopedics',
        'phone' => '9865001102',
        'fee' => 800,
        'status' => 'Active',
        'email' => 'rajesh.patel@clinic.demo',
        'clinic_id' => 2,
      ),
      2 => 
      array (
        'name' => 'Dr. Kavita Desai',
        'specialty' => 'Pediatrics',
        'phone' => '9865001103',
        'fee' => 600,
        'status' => 'Active',
        'email' => 'kavita.desai@clinic.demo',
        'clinic_id' => 1,
      ),
      3 => 
      array (
        'name' => 'Dr. Manoj Trivedi',
        'specialty' => 'Dermatology',
        'phone' => '9865001104',
        'fee' => 700,
        'status' => 'Active',
        'email' => 'manoj.trivedi@clinic.demo',
        'clinic_id' => 2,
      ),
    ),
    'Appointment' => 
    array (
      0 => 
      array (
        'patient_id' => 1,
        'doctor_id' => 1,
        'appt_date' => '2026-11-19',
        'appt_time' => '10:30',
        'reason' => 'Fever & cold',
        'status' => 'Scheduled',
        'clinic_id' => 1,
      ),
      1 => 
      array (
        'patient_id' => 2,
        'doctor_id' => 4,
        'appt_date' => '2026-11-19',
        'appt_time' => '11:15',
        'reason' => 'Skin rash',
        'status' => 'Scheduled',
        'clinic_id' => 2,
      ),
      2 => 
      array (
        'patient_id' => 3,
        'doctor_id' => 2,
        'appt_date' => '2026-11-20',
        'appt_time' => '09:45',
        'reason' => 'Knee pain',
        'status' => 'Scheduled',
        'clinic_id' => 1,
      ),
    ),
    'Bill' => 
    array (
      0 => 
      array (
        'invoice_no' => 'BILL-1001',
        'patient_id' => 1,
        'description' => 'Consultation',
        'amount' => 500,
        'status' => 'Paid',
        'paid_at' => '2026-11-19',
      ),
      1 => 
      array (
        'invoice_no' => 'BILL-1002',
        'patient_id' => 2,
        'description' => 'Consultation + Test',
        'amount' => 1500,
        'status' => 'Pending',
        'paid_at' => '2026-11-19',
      ),
    ),
    'Schedule' => 
    array (
      0 => 
      array (
        'doctor_id' => 1,
        'clinic_id' => 1,
        'day' => 'Monday',
        'start_time' => '09:00',
        'end_time' => '13:00',
        'slot_min' => 20,
        'status' => 'Active',
      ),
      1 => 
      array (
        'doctor_id' => 1,
        'clinic_id' => 1,
        'day' => 'Wednesday',
        'start_time' => '17:00',
        'end_time' => '20:00',
        'slot_min' => 20,
        'status' => 'Active',
      ),
      2 => 
      array (
        'doctor_id' => 2,
        'clinic_id' => 2,
        'day' => 'Tuesday',
        'start_time' => '10:00',
        'end_time' => '14:00',
        'slot_min' => 30,
        'status' => 'Active',
      ),
      3 => 
      array (
        'doctor_id' => 2,
        'clinic_id' => 2,
        'day' => 'Friday',
        'start_time' => '10:00',
        'end_time' => '14:00',
        'slot_min' => 30,
        'status' => 'Active',
      ),
    ),
    'Payment' => 
    array (
      0 => 
      array (
        'appointment_id' => 1,
        'amount' => 500,
        'method' => 'Stripe',
        'status' => 'Paid',
        'receipt_no' => 'RCP-1001',
        'txn_ref' => 'txn_demo_8f3k2',
      ),
      1 => 
      array (
        'appointment_id' => 2,
        'amount' => 300,
        'method' => 'Cash',
        'status' => 'Paid',
        'receipt_no' => 'RCP-1002',
        'txn_ref' => NULL,
      ),
    ),
  ),
);
