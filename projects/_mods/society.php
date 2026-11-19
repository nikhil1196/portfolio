<?php
// Society — injected modules: maintenance receipts/payments, visitors, staff & vendors, parking
return [
    'base_tables' => ['Unit' => 'units', 'Resident' => 'residents', 'Maintenance' => 'maintenances'],
    'nav' => [
        ['Receipts', 'receipts.index', 'receipt'],
        ['Visitors', 'visitors.index', 'user'],
        ['Staff & Vendors', 'staff.index', 'briefcase'],
        ['Parking', 'parking.index', 'grid'],
    ],
    'modules' => [
        'receipts' => [
            'model' => 'Receipt', 'title' => 'Maintenance Receipt', 'icon' => 'receipt',
            'columns' => [['maintenance_id','fkreq:Maintenance'],['unit_id','fkreq:Unit'],['amount','decimal'],['method','default:Online'],['txn_ref','stringNullable'],['receipt_no','stringNullable'],['status','default:Paid']],
            'fillable' => ['maintenance_id','unit_id','amount','method','txn_ref','status'],
            'validation' => ['maintenance_id'=>'required|exists:maintenance,id','unit_id'=>'required|exists:units,id','amount'=>'required|numeric|min:0','method'=>'required|in:Online,UPI,Card,Cash,Cheque','txn_ref'=>'nullable|string','status'=>'required|in:Paid,Pending,Failed'],
            'store_extra' => "\$data['receipt_no'] = 'SR-' . str_pad((string)(\\App\\Models\\Receipt::max('id') + 5001), 4, '0', STR_PAD_LEFT);",
            'fields' => [
                ['maintenance_id','Maintenance Bill','select','@Maintenance:id',true], ['unit_id','Unit','select','@Unit:flat_no',true],
                ['amount','Amount (₹)','number',null,true], ['method','Method','select',['Online','UPI','Card','Cash','Cheque'],true],
                ['txn_ref','Transaction Ref','text'], ['status','Status','select',['Paid','Pending','Failed']],
            ],
            'with' => ['maintenance','unit'],
            'rels' => ['maintenance' => 'belongsTo:Maintenance', 'unit' => 'belongsTo:Unit'],
            'cols' => [
                'Receipt' => '<strong>{{ $r->receipt_no }}</strong>', 'Unit' => '{{ $r->unit->flat_no }}',
                'Bill #' => '#{{ $r->maintenance_id }}', 'Amount' => '₹{{ number_format($r->amount) }}',
                'Method' => '{{ $r->method }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'visitors' => [
            'model' => 'Visitor', 'title' => 'Visitor', 'icon' => 'user',
            'columns' => [['unit_id','fkreq:Unit'],['name','string'],['phone','stringNullable'],['purpose','stringNullable'],['check_in','datetime'],['check_out','datetimeNullable'],['status','default:Inside']],
            'fillable' => ['unit_id','name','phone','purpose','check_in','check_out','status'],
            'validation' => ['unit_id'=>'required|exists:units,id','name'=>'required|string|max:255','phone'=>'nullable|string','purpose'=>'nullable|string','check_in'=>'required|date','check_out'=>'nullable|date','status'=>'required|in:Inside,Left'],
            'fields' => [
                ['unit_id','Visiting Unit','select','@Unit:flat_no',true], ['name','Visitor Name','text',null,true],
                ['phone','Phone','tel'], ['purpose','Purpose','text'],
                ['check_in','Check-in','datetime-local',null,true], ['check_out','Check-out','datetime-local'],
                ['status','Status','select',['Inside','Left']],
            ],
            'with' => ['unit'],
            'rels' => ['unit' => 'belongsTo:Unit'],
            'cols' => [
                'Visitor' => '<strong>{{ $r->name }}</strong>', 'Unit' => '{{ $r->unit->flat_no }}',
                'Purpose' => '{{ $r->purpose }}', 'In' => '{{ $r->check_in }}',
                'Out' => '{{ $r->check_out ?? "—" }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'staff' => [
            'model' => 'Staff', 'title' => 'Staff / Vendor', 'icon' => 'briefcase', 'table' => 'staff',
            'columns' => [['name','string'],['role','stringNullable'],['phone','stringNullable'],['shift','stringNullable'],['status','statusActive']],
            'fillable' => ['name','role','phone','shift','status'],
            'validation' => ['name'=>'required|string|max:255','role'=>'nullable|string','phone'=>'nullable|string','shift'=>'nullable|string','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Name','text',null,true], ['role','Role','select',['Security','Gardener','Cleaner','Electrician','Plumber','Vendor','Other'],true],
                ['phone','Phone','tel'], ['shift','Shift','select',['Morning','Evening','Night','On-call']],
                ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Name' => '<strong>{{ $r->name }}</strong>', 'Role' => '{{ $r->role }}',
                'Phone' => '{{ $r->phone }}', 'Shift' => '{{ $r->shift }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'parking' => [
            'model' => 'Parking', 'title' => 'Parking Slot', 'icon' => 'grid', 'table' => 'parking',
            'columns' => [['slot_no','string'],['unit_id','fk:Unit'],['vehicle_no','stringNullable'],['vehicle_type','default:Car'],['status','default:Assigned']],
            'fillable' => ['slot_no','unit_id','vehicle_no','vehicle_type','status'],
            'validation' => ['slot_no'=>'required|string|max:20','unit_id'=>'nullable|exists:units,id','vehicle_no'=>'nullable|string','vehicle_type'=>'required|in:Car,Bike,Scooter,Other','status'=>'required|in:Assigned,Free,Blocked'],
            'fields' => [
                ['slot_no','Slot No.','text',null,true], ['unit_id','Unit','select','@Unit:flat_no'],
                ['vehicle_no','Vehicle No.','text'], ['vehicle_type','Type','select',['Car','Bike','Scooter','Other'],true],
                ['status','Status','select',['Assigned','Free','Blocked']],
            ],
            'with' => ['unit'],
            'rels' => ['unit' => 'belongsTo:Unit'],
            'cols' => [
                'Slot' => '<strong>{{ $r->slot_no }}</strong>', 'Unit' => '{{ $r->unit->flat_no ?? "—" }}',
                'Vehicle' => '{{ $r->vehicle_no }}', 'Type' => '{{ $r->vehicle_type }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
    ],
    'seed' => [
        'Receipt' => [
            ['maintenance_id'=>1,'unit_id'=>1,'amount'=>2500,'method'=>'Online','txn_ref'=>'upi_demo_9x2k','status'=>'Paid'],
            ['maintenance_id'=>2,'unit_id'=>2,'amount'=>2500,'method'=>'UPI','txn_ref'=>'upi_demo_7m4p','status'=>'Paid'],
        ],
        'Visitor' => [
            ['unit_id'=>1,'name'=>'Courier - Amazon','phone'=>null,'purpose'=>'Delivery','check_in'=>'2026-11-19 10:15','check_out'=>'2026-11-19 10:25','status'=>'Left'],
            ['unit_id'=>3,'name'=>'Suresh Kumar','phone'=>'9822001100','purpose'=>'Family visit','check_in'=>'2026-11-19 18:00','check_out'=>null,'status'=>'Inside'],
        ],
        'Staff' => [
            ['name'=>'Raju Singh','role'=>'Security','phone'=>'9811002200','shift'=>'Night','status'=>'Active'],
            ['name'=>'Meena Devi','role'=>'Cleaner','phone'=>'9811002211','shift'=>'Morning','status'=>'Active'],
            ['name'=>'PowerFix Services','role'=>'Electrician','phone'=>'9811002222','shift'=>'On-call','status'=>'Active'],
        ],
        'Parking' => [
            ['slot_no'=>'P-01','unit_id'=>1,'vehicle_no'=>'GJ06AB1234','vehicle_type'=>'Car','status'=>'Assigned'],
            ['slot_no'=>'P-02','unit_id'=>2,'vehicle_no'=>'GJ06CD5678','vehicle_type'=>'Car','status'=>'Assigned'],
            ['slot_no'=>'P-15','unit_id'=>null,'vehicle_no'=>null,'vehicle_type'=>'Car','status'=>'Free'],
        ],
    ],
];
