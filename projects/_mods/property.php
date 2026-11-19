<?php
// Property — expenses + documents
return [
    'base_tables' => ['Property' => 'properties', 'Tenant' => 'tenants', 'Lease' => 'leases'],
    'nav' => [
        ['Expenses', 'expenses.index', 'money'],
        ['Documents', 'documents.index', 'clipboard'],
    ],
    'modules' => [
        'expenses' => [
            'model' => 'Expense', 'title' => 'Expense', 'icon' => 'money',
            'columns' => [['property_id','fkreq:Property'],['category','default:Repair'],['amount','decimal'],['exp_date','date'],['notes','textNullable'],['status','default:Paid']],
            'fillable' => ['property_id','category','amount','exp_date','notes','status'],
            'validation' => ['property_id'=>'required|exists:properties,id','category'=>'required|in:Repair,Utilities,Tax,Insurance,Cleaning,Other','amount'=>'required|numeric|min:0','exp_date'=>'required|date','notes'=>'nullable|string','status'=>'required|in:Paid,Pending'],
            'fields' => [
                ['property_id','Property','select','@Property:title',true], ['category','Category','select',['Repair','Utilities','Tax','Insurance','Cleaning','Other'],true],
                ['amount','Amount (₹)','number',null,true], ['exp_date','Date','date',null,true],
                ['notes','Notes','textarea'], ['status','Status','select',['Paid','Pending']],
            ],
            'with' => ['property'],
            'rels' => ['property' => 'belongsTo:Property'],
            'cols' => [
                'Property' => '<strong>{{ $r->property->title }}</strong>', 'Category' => '<span class="badge">{{ $r->category }}</span>',
                'Amount' => '₹{{ number_format($r->amount) }}', 'Date' => '{{ $r->exp_date }}',
                'Status' => '{{ $r->status }}',
            ],
        ],
        'documents' => [
            'model' => 'Document', 'title' => 'Document', 'icon' => 'clipboard',
            'columns' => [['property_id','fkreq:Property'],['tenant_id','fk:Tenant'],['title','string'],['type','default:Agreement'],['file_path','stringNullable'],['status','statusActive']],
            'fillable' => ['property_id','tenant_id','title','type','file_path','status'],
            'validation' => ['property_id'=>'required|exists:properties,id','tenant_id'=>'nullable|exists:tenants,id','title'=>'required|string|max:255','type'=>'required|in:Agreement,ID Proof,Invoice,Notice,Other','file_path'=>'nullable|string','status'=>'required|in:Active,Archived'],
            'fields' => [
                ['property_id','Property','select','@Property:title',true], ['tenant_id','Tenant','select','@Tenant'],
                ['title','Document','text',null,true], ['type','Type','select',['Agreement','ID Proof','Invoice','Notice','Other'],true],
                ['file_path','File / Link','text'], ['status','Status','select',['Active','Archived']],
            ],
            'with' => ['property','tenant'],
            'rels' => ['property' => 'belongsTo:Property', 'tenant' => 'belongsTo:Tenant'],
            'cols' => [
                'Document' => '<strong>{{ $r->title }}</strong>', 'Property' => '{{ $r->property->title }}',
                'Tenant' => '{{ $r->tenant->name ?? "—" }}', 'Type' => '<span class="badge">{{ $r->type }}</span>',
                'Status' => '{{ $r->status }}',
            ],
        ],
    ],
    'seed' => [
        'Expense' => [
            ['property_id'=>1,'category'=>'Repair','amount'=>3500,'exp_date'=>'2026-11-10','notes'=>'Plumbing fix, unit 2B','status'=>'Paid'],
            ['property_id'=>1,'category'=>'Utilities','amount'=>1200,'exp_date'=>'2026-11-15','notes'=>'Common area electricity','status'=>'Paid'],
        ],
        'Document' => [
            ['property_id'=>1,'tenant_id'=>1,'title'=>'Lease Agreement 2026','type'=>'Agreement','file_path'=>'docs/lease1.pdf','status'=>'Active'],
        ],
    ],
];
