<?php
// HRMS — holidays, announcements, employee documents
return [
    'base_tables' => ['Employee' => 'employees', 'Department' => 'departments'],
    'nav' => [
        ['Holidays', 'holidays.index', 'calendar'],
        ['Announcements', 'announcements.index', 'alert'],
        ['Documents', 'documents.index', 'clipboard'],
    ],
    'modules' => [
        'holidays' => [
            'model' => 'Holiday', 'title' => 'Holiday', 'icon' => 'calendar',
            'columns' => [['name','string'],['hdate','date'],['type','default:Public'],['status','statusActive']],
            'fillable' => ['name','hdate','type','status'],
            'validation' => ['name'=>'required|string|max:255','hdate'=>'required|date','type'=>'required|in:Public,Festival,Company,Optional','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Holiday','text',null,true], ['hdate','Date','date',null,true],
                ['type','Type','select',['Public','Festival','Company','Optional'],true],
                ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Name' => '<strong>{{ $r->name }}</strong>', 'Date' => '{{ $r->hdate }}',
                'Type' => '<span class="badge">{{ $r->type }}</span>', 'Status' => '{{ $r->status }}',
            ],
        ],
        'announcements' => [
            'model' => 'Announcement', 'title' => 'Announcement', 'icon' => 'alert',
            'columns' => [['title','string'],['body','textNullable'],['audience','default:All'],['publish_date','date'],['status','statusActive']],
            'fillable' => ['title','body','audience','publish_date','status'],
            'validation' => ['title'=>'required|string|max:255','body'=>'nullable|string','audience'=>'required|in:All,Management,Staff','publish_date'=>'required|date','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['title','Title','text',null,true], ['audience','Audience','select',['All','Management','Staff'],true],
                ['publish_date','Publish Date','date',null,true], ['body','Message','textarea'],
                ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Title' => '<strong>{{ $r->title }}</strong>', 'Audience' => '{{ $r->audience }}',
                'Published' => '{{ $r->publish_date }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'documents' => [
            'model' => 'Document', 'title' => 'Employee Document', 'icon' => 'clipboard',
            'columns' => [['employee_id','fkreq:Employee'],['title','string'],['type','default:ID Proof'],['file_path','stringNullable'],['expiry','dateNullable'],['status','statusActive']],
            'fillable' => ['employee_id','title','type','file_path','expiry','status'],
            'validation' => ['employee_id'=>'required|exists:employees,id','title'=>'required|string|max:255','type'=>'required|in:ID Proof,Contract,Certificate,Offer Letter,Other','file_path'=>'nullable|string','expiry'=>'nullable|date','status'=>'required|in:Active,Expired'],
            'fields' => [
                ['employee_id','Employee','select','@Employee',true], ['title','Document Title','text',null,true],
                ['type','Type','select',['ID Proof','Contract','Certificate','Offer Letter','Other'],true],
                ['file_path','File / Link','text'], ['expiry','Expiry','date'],
                ['status','Status','select',['Active','Expired']],
            ],
            'with' => ['employee'],
            'rels' => ['employee' => 'belongsTo:Employee'],
            'cols' => [
                'Employee' => '<strong>{{ $r->employee->name }}</strong>', 'Document' => '{{ $r->title }}',
                'Type' => '<span class="badge">{{ $r->type }}</span>', 'Expiry' => '{{ $r->expiry ?? "—" }}',
                'Status' => '{{ $r->status }}',
            ],
        ],
    ],
    'seed' => [
        'Holiday' => [
            ['name'=>'Diwali','hdate'=>'2026-11-08','type'=>'Festival','status'=>'Active'],
            ['name'=>'Christmas','hdate'=>'2026-12-25','type'=>'Public','status'=>'Active'],
            ['name'=>'Foundation Day','hdate'=>'2026-12-01','type'=>'Company','status'=>'Active'],
        ],
        'Announcement' => [
            ['title'=>'Year-end party','body'=>'All hands invited — Dec 30','audience'=>'All','publish_date'=>'2026-11-19','status'=>'Active'],
            ['title'=>'Appraisal cycle opens','body'=>'Self-review due by Dec 15','audience'=>'Staff','publish_date'=>'2026-12-01','status'=>'Active'],
        ],
        'Document' => [
            ['employee_id'=>1,'title'=>'Aadhaar Card','type'=>'ID Proof','file_path'=>'docs/emp1_aadhaar.pdf','expiry'=>null,'status'=>'Active'],
            ['employee_id'=>1,'title'=>'Employment Contract','type'=>'Contract','file_path'=>'docs/emp1_contract.pdf','expiry'=>'2027-12-31','status'=>'Active'],
        ],
    ],
];
