<?php
return [
    'name' => 'Property Management', 'accent' => '#6c5ce7', 'icon' => '▣',
    'nav' => [
        ['Dashboard', 'dashboard', '⌂'], ['Properties', 'properties.index', '▣'],
        ['Tenants', 'tenants.index', '◉'], ['Leases', 'leases.index', '▤'],
        ['Rent', 'rents.index', '₹'], ['Requests', 'requests.index', '✉'],
    ],
    'uses' => "use App\\Models\\Lease;\nuse App\\Models\\Property;\nuse App\\Models\\Rent;",
    'stats' => [
        ['Properties', 'Property::count()', 'listed'],
        ['Occupied', "Property::where('status','Occupied')->count()", 'units'],
        ['Active Leases', "Lease::where('status','Active')->count()", 'running'],
        ['Rent Due', "'₹'.number_format(Rent::where('status','Due')->sum('amount'))", 'this cycle'],
    ],
    'dash' => [
        'title' => 'Pending Rent', 'link' => ['rents.index', 'All'],
        'query' => "Rent::with(['lease.property','lease.tenant'])->where('status','Due')->latest()->limit(8)->get()",
        'cols' => ['Property' => '{{ $r->lease->property->title ?? "—" }}', 'Tenant' => '<strong>{{ $r->lease->tenant->name ?? "—" }}</strong>', 'Month' => '{{ $r->month }}', 'Amount' => '₹{{ number_format($r->amount) }}', 'Status' => '<span class="badge">{{ $r->status }}</span>'],
        'empty' => 'All rent collected',
    ],
    'modules' => [
        'properties' => [
            'model' => 'Property', 'title' => 'Property', '_mid' => 1,
            'columns' => [['title','string'],['type','stringNullable'],['address','stringNullable'],['city','stringNullable'],['rent','decimal'],['status','default:Available']],
            'fillable' => ['title','type','address','city','rent','status'],
            'validation' => ['title'=>'required|string|max:255','type'=>'nullable|string','address'=>'nullable|string','city'=>'nullable|string','rent'=>'nullable|numeric|min:0','status'=>'required|in:Available,Occupied,Maintenance'],
            'fields' => [
                ['title','Property Title','text',null,true],
                ['type','Type','select',['Apartment','Villa','Studio','Commercial','Shop','Plot']],
                ['address','Address','text'], ['city','City','text'], ['rent','Rent (₹/mo)','number'],
                ['status','Status','select',['Available','Occupied','Maintenance']],
            ],
            'cols' => [
                'Property' => '<strong>{{ $r->title }}</strong>', 'Type' => '{{ $r->type }}',
                'Location' => '{{ $r->address }}, {{ $r->city }}', 'Rent' => '₹{{ number_format($r->rent) }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'tenants' => [
            'model' => 'Tenant', 'title' => 'Tenant', '_mid' => 2,
            'columns' => [['name','string'],['phone','stringNullable'],['email','stringNullable'],['id_proof','stringNullable'],['status','statusActive']],
            'fillable' => ['name','phone','email','id_proof','status'],
            'validation' => ['name'=>'required|string|max:255','phone'=>'nullable|string|max:20','email'=>'nullable|email','id_proof'=>'nullable|string','status'=>'required|in:Active,Moved Out'],
            'fields' => [
                ['name','Tenant Name','text',null,true], ['phone','Phone','tel'],
                ['email','Email','email'], ['id_proof','ID Proof','text'],
                ['status','Status','select',['Active','Moved Out']],
            ],
            'cols' => [
                'Name' => '<strong>{{ $r->name }}</strong>', 'Phone' => '{{ $r->phone }}',
                'Email' => '{{ $r->email }}', 'ID Proof' => '{{ $r->id_proof }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'leases' => [
            'model' => 'Lease', 'title' => 'Lease', '_mid' => 3,
            'columns' => [['property_id','fkreq:Property'],['tenant_id','fkreq:Tenant'],['start_date','date'],['end_date','date'],['rent','decimal'],['deposit','decimal'],['status','statusActive']],
            'fillable' => ['property_id','tenant_id','start_date','end_date','rent','deposit','status'],
            'validation' => ['property_id'=>'required|exists:properties,id','tenant_id'=>'required|exists:tenants,id','start_date'=>'required|date','end_date'=>'required|date','rent'=>'required|numeric|min:0','deposit'=>'nullable|numeric|min:0','status'=>'required|in:Active,Expired,Terminated'],
            'fields' => [
                ['property_id','Property','select','@Property:title',true], ['tenant_id','Tenant','select','@Tenant',true],
                ['start_date','Start Date','date',null,true], ['end_date','End Date','date',null,true],
                ['rent','Monthly Rent (₹)','number',null,true], ['deposit','Deposit (₹)','number'],
                ['status','Status','select',['Active','Expired','Terminated']],
            ],
            'with' => ['property','tenant'],
            'rels' => ['property' => 'belongsTo:Property', 'tenant' => 'belongsTo:Tenant'],
            'cols' => [
                'Property' => '<strong>{{ $r->property->title ?? "—" }}</strong>', 'Tenant' => '{{ $r->tenant->name ?? "—" }}',
                'Period' => '{{ $r->start_date }} → {{ $r->end_date }}', 'Rent' => '₹{{ number_format($r->rent) }}',
                'Deposit' => '₹{{ number_format($r->deposit) }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'rents' => [
            'model' => 'Rent', 'title' => 'Rent Record', '_mid' => 4,
            'columns' => [['lease_id','fkreq:Lease'],['month','stringNullable'],['amount','decimal'],['status','default:Due'],['paid_at','dateNullable']],
            'fillable' => ['lease_id','month','amount','status','paid_at'],
            'validation' => ['lease_id'=>'required|exists:leases,id','month'=>'required|string|max:10','amount'=>'required|numeric|min:0','status'=>'required|in:Paid,Due,Overdue','paid_at'=>'nullable|date'],
            'fields' => [
                ['lease_id','Lease','select','@Lease:id',true], ['month','Month','month',null,true],
                ['amount','Amount (₹)','number',null,true],
                ['status','Status','select',['Paid','Due','Overdue']], ['paid_at','Paid On','date'],
            ],
            'with' => ['lease.property','lease.tenant'],
            'rels' => ['lease' => 'belongsTo:Lease'],
            'cols' => [
                'Property' => '<strong>{{ $r->lease->property->title ?? "—" }}</strong>', 'Tenant' => '{{ $r->lease->tenant->name ?? "—" }}',
                'Month' => '{{ $r->month }}', 'Amount' => '₹{{ number_format($r->amount) }}',
                'Paid On' => '{{ $r->paid_at ?? "—" }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'requests' => [
            'model' => 'MaintenanceRequest', 'title' => 'Maintenance Request', 'table' => 'requests', '_mid' => 5,
            'columns' => [['property_id','fkreq:Property'],['tenant_id','fk:Tenant'],['category','stringNullable'],['subject','string'],['status','default:Open']],
            'fillable' => ['property_id','tenant_id','category','subject','status'],
            'validation' => ['property_id'=>'required|exists:properties,id','tenant_id'=>'nullable|exists:tenants,id','category'=>'nullable|string','subject'=>'required|string','status'=>'required|in:Open,In Progress,Resolved'],
            'fields' => [
                ['property_id','Property','select','@Property:title',true], ['tenant_id','Raised By','select','@Tenant'],
                ['category','Category','select',['Plumbing','Electrical','Carpentry','General','Pest Control']],
                ['subject','Issue','text',null,true],
                ['status','Status','select',['Open','In Progress','Resolved']],
            ],
            'with' => ['property','tenant'],
            'rels' => ['property' => 'belongsTo:Property', 'tenant' => 'belongsTo:Tenant'],
            'cols' => [
                'Issue' => '<strong>{{ $r->subject }}</strong>', 'Property' => '{{ $r->property->title ?? "—" }}',
                'Raised By' => '{{ $r->tenant->name ?? "—" }}', 'Category' => '{{ $r->category }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
    ],
    'seed' => [
        'Property' => [
            ['title'=>'Sunrise Residency 2BHK','type'=>'Apartment','address'=>'Alkapuri','city'=>'Vadodara','rent'=>18000,'status'=>'Occupied'],
            ['title'=>'Green Villa 3BHK','type'=>'Villa','address'=>'Gotri','city'=>'Vadodara','rent'=>35000,'status'=>'Occupied'],
            ['title'=>'Lakeview Studio','type'=>'Studio','address'=>'Fatehgunj','city'=>'Vadodara','rent'=>12000,'status'=>'Available'],
            ['title'=>'Skyline Office 800sqft','type'=>'Commercial','address'=>'Sayajigunj','city'=>'Vadodara','rent'=>45000,'status'=>'Occupied'],
        ],
        'Tenant' => [
            ['name'=>'Deepak Rana','phone'=>'9811100001','email'=>'deepak@example.com','id_proof'=>'Aadhaar XXXX1234','status'=>'Active'],
            ['name'=>'Shreya Nambiar','phone'=>'9811100002','email'=>'shreya@example.com','id_proof'=>'PAN XXXX5678','status'=>'Active'],
            ['name'=>'Wasim Pathan','phone'=>'9811100003','email'=>'wasim@example.com','id_proof'=>'Aadhaar XXXX9012','status'=>'Active'],
        ],
        'Lease' => [
            ['property_id'=>1,'tenant_id'=>1,'start_date'=>'2026-01-01','end_date'=>'2026-12-31','rent'=>18000,'deposit'=>54000,'status'=>'Active'],
            ['property_id'=>2,'tenant_id'=>2,'start_date'=>'2026-04-01','end_date'=>'2027-03-31','rent'=>35000,'deposit'=>105000,'status'=>'Active'],
            ['property_id'=>4,'tenant_id'=>3,'start_date'=>'2026-06-01','end_date'=>'2029-05-31','rent'=>45000,'deposit'=>135000,'status'=>'Active'],
        ],
        'Rent' => [
            ['lease_id'=>1,'month'=>'2026-11','amount'=>18000,'status'=>'Paid','paid_at'=>'2026-11-03'],
            ['lease_id'=>2,'month'=>'2026-11','amount'=>35000,'status'=>'Due','paid_at'=>null],
            ['lease_id'=>3,'month'=>'2026-11','amount'=>45000,'status'=>'Paid','paid_at'=>'2026-11-08'],
        ],
        'MaintenanceRequest' => [
            ['property_id'=>1,'tenant_id'=>1,'category'=>'Plumbing','subject'=>'Kitchen tap leaking','status'=>'In Progress'],
            ['property_id'=>2,'tenant_id'=>2,'category'=>'Electrical','subject'=>'Bedroom fan not working','status'=>'Open'],
        ],
    ],
];
