<?php
return [
    'name' => 'CRM', 'accent' => '#00cec9', 'icon' => '◎',
    'nav' => [
        ['Dashboard', 'dashboard', '⌂'], ['Contacts', 'contacts.index', '◉'],
        ['Leads', 'leads.index', '◎'], ['Deals', 'deals.index', '₹'], ['Tasks', 'tasks.index', '✓'],
    ],
    'uses' => "use App\\Models\\Contact;\nuse App\\Models\\Deal;\nuse App\\Models\\Lead;\nuse App\\Models\\Task;",
    'stats' => [
        ['Contacts', 'Contact::count()', 'in database'],
        ['Open Leads', "Lead::whereNotIn('stage', ['Won','Lost'])->count()", 'in pipeline'],
        ['Pipeline Value', "'₹'.number_format(Deal::where('status','Open')->sum('value'))", 'open deals'],
        ['Deals Won', "'₹'.number_format(Deal::where('stage','Won')->sum('value'))", 'closed'],
    ],
    'dash' => [
        'title' => 'Upcoming Tasks', 'link' => ['tasks.index', 'All'],
        'query' => "Task::with('contact')->where('status','Open')->orderBy('due_date')->limit(8)->get()",
        'cols' => ['Task' => '<strong>{{ $r->title }}</strong>', 'Contact' => '{{ $r->contact->name ?? "—" }}', 'Due' => '{{ $r->due_date }}', 'Priority' => '<span class="badge">{{ $r->priority }}</span>'],
        'empty' => 'All caught up',
    ],
    'modules' => [
        'contacts' => [
            'model' => 'Contact', 'title' => 'Contact', '_mid' => 1,
            'columns' => [['name','string'],['company','stringNullable'],['email','stringNullable'],['phone','stringNullable'],['source','stringNullable'],['status','statusActive']],
            'fillable' => ['name','company','email','phone','source','status'],
            'validation' => ['name'=>'required|string|max:255','company'=>'nullable|string','email'=>'nullable|email','phone'=>'nullable|string|max:20','source'=>'nullable|string','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Contact Name','text',null,true], ['company','Company','text'],
                ['email','Email','email'], ['phone','Phone','tel'],
                ['source','Source','select',['Website','Referral','Cold Call','LinkedIn','Expo','Other']],
                ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Name' => '<strong>{{ $r->name }}</strong>', 'Company' => '{{ $r->company }}',
                'Email' => '{{ $r->email }}', 'Phone' => '{{ $r->phone }}',
                'Source' => '{{ $r->source }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'leads' => [
            'model' => 'Lead', 'title' => 'Lead', '_mid' => 2,
            'columns' => [['contact_id','fk:Contact'],['title','string'],['value','decimal'],['stage','default:New'],['owner','stringNullable'],['notes','textNullable']],
            'fillable' => ['contact_id','title','value','stage','owner','notes'],
            'validation' => ['contact_id'=>'nullable|exists:contacts,id','title'=>'required|string|max:255','value'=>'nullable|numeric|min:0','stage'=>'required|in:New,Contacted,Qualified,Proposal,Negotiation,Won,Lost','owner'=>'nullable|string','notes'=>'nullable|string'],
            'fields' => [
                ['contact_id','Contact','select','@Contact'], ['title','Lead Title','text',null,true],
                ['value','Est. Value (₹)','number'],
                ['stage','Stage','select',['New','Contacted','Qualified','Proposal','Negotiation','Won','Lost']],
                ['owner','Owner','text'], ['notes','Notes','textarea'],
            ],
            'with' => ['contact'],
            'rels' => ['contact' => 'belongsTo:Contact'],
            'cols' => [
                'Lead' => '<strong>{{ $r->title }}</strong>', 'Contact' => '{{ $r->contact->name ?? "—" }}<br><span class="note">{{ $r->contact->company ?? "" }}</span>',
                'Value' => '₹{{ number_format($r->value) }}', 'Stage' => '<span class="badge">{{ $r->stage }}</span>',
                'Owner' => '{{ $r->owner }}',
            ],
        ],
        'deals' => [
            'model' => 'Deal', 'title' => 'Deal', '_mid' => 3,
            'columns' => [['contact_id','fkreq:Contact'],['title','string'],['value','decimal'],['stage','default:Qualification'],['close_date','dateNullable'],['status','default:Open']],
            'fillable' => ['contact_id','title','value','stage','close_date','status'],
            'validation' => ['contact_id'=>'required|exists:contacts,id','title'=>'required|string|max:255','value'=>'required|numeric|min:0','stage'=>'required|in:Qualification,Proposal,Negotiation,Won,Lost','close_date'=>'nullable|date','status'=>'required|in:Open,Closed'],
            'fields' => [
                ['contact_id','Contact','select','@Contact',true], ['title','Deal Title','text',null,true],
                ['value','Deal Value (₹)','number',null,true],
                ['stage','Stage','select',['Qualification','Proposal','Negotiation','Won','Lost']],
                ['close_date','Expected Close','date'], ['status','Status','select',['Open','Closed']],
            ],
            'with' => ['contact'],
            'rels' => ['contact' => 'belongsTo:Contact'],
            'cols' => [
                'Deal' => '<strong>{{ $r->title }}</strong>', 'Contact' => '{{ $r->contact->name ?? "—" }}',
                'Value' => '₹{{ number_format($r->value) }}', 'Stage' => '<span class="badge">{{ $r->stage }}</span>',
                'Close' => '{{ $r->close_date }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'tasks' => [
            'model' => 'Task', 'title' => 'Task', '_mid' => 4,
            'columns' => [['contact_id','fk:Contact'],['title','string'],['due_date','dateNullable'],['priority','default:Medium'],['status','default:Open']],
            'fillable' => ['contact_id','title','due_date','priority','status'],
            'validation' => ['contact_id'=>'nullable|exists:contacts,id','title'=>'required|string|max:255','due_date'=>'nullable|date','priority'=>'required|in:High,Medium,Low','status'=>'required|in:Open,Done,Cancelled'],
            'fields' => [
                ['contact_id','Contact','select','@Contact'], ['title','Task','text',null,true],
                ['due_date','Due Date','date',null,true],
                ['priority','Priority','select',['High','Medium','Low']],
                ['status','Status','select',['Open','Done','Cancelled']],
            ],
            'with' => ['contact'],
            'rels' => ['contact' => 'belongsTo:Contact'],
            'cols' => [
                'Task' => '<strong>{{ $r->title }}</strong>', 'Contact' => '{{ $r->contact->name ?? "—" }}',
                'Due' => '{{ $r->due_date }}', 'Priority' => '<span class="badge">{{ $r->priority }}</span>',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
    ],
    'seed' => [
        'Contact' => [
            ['name'=>'Rajat Malhotra','company'=>'Zenith Textiles','email'=>'rajat@zenith.com','phone'=>'9820100001','source'=>'Referral','status'=>'Active'],
            ['name'=>'Komal Jain','company'=>'FreshMart Retail','email'=>'komal@freshmart.in','phone'=>'9820100002','source'=>'Website','status'=>'Active'],
            ['name'=>'Sahil Bhatia','company'=>'Bhatia Logistics','email'=>'sahil@bhatia.co','phone'=>'9820100003','source'=>'Cold Call','status'=>'Active'],
            ['name'=>'Tanvi Kulkarni','company'=>'Nimbus IT Park','email'=>'tanvi@nimbus.com','phone'=>'9820100004','source'=>'LinkedIn','status'=>'Active'],
        ],
        'Lead' => [
            ['contact_id'=>1,'title'=>'ERP for textile unit','value'=>450000,'stage'=>'Qualified','owner'=>'Nikhil','notes'=>'Wants GST + inventory module'],
            ['contact_id'=>2,'title'=>'POS for 12 stores','value'=>800000,'stage'=>'Proposal','owner'=>'Nikhil','notes'=>'Sent pricing deck'],
            ['contact_id'=>3,'title'=>'Fleet tracking portal','value'=>250000,'stage'=>'Contacted','owner'=>'Amit','notes'=>'Demo scheduled'],
        ],
        'Deal' => [
            ['contact_id'=>1,'title'=>'Zenith ERP Phase 1','value'=>300000,'stage'=>'Negotiation','close_date'=>'2026-12-15','status'=>'Open'],
            ['contact_id'=>2,'title'=>'FreshMart POS rollout','value'=>800000,'stage'=>'Proposal','close_date'=>'2027-01-31','status'=>'Open'],
            ['contact_id'=>3,'title'=>'Fleet portal MVP','value'=>250000,'stage'=>'Won','close_date'=>'2026-11-01','status'=>'Closed'],
        ],
        'Task' => [
            ['contact_id'=>1,'title'=>'Send revised ERP quote','due_date'=>date('Y-m-d',strtotime('+1 day')),'priority'=>'High','status'=>'Open'],
            ['contact_id'=>2,'title'=>'POS hardware checklist','due_date'=>date('Y-m-d',strtotime('+3 day')),'priority'=>'Medium','status'=>'Open'],
        ],
    ],
];
