<?php
// CRM — activities timeline, products, quotes
return [
    'base_tables' => ['Lead' => 'leads', 'Deal' => 'deals', 'Contact' => 'contacts'],
    'nav' => [
        ['Activities', 'activities.index', 'check'],
        ['Products', 'products.index', 'grid'],
        ['Quotes', 'quotes.index', 'receipt'],
    ],
    'modules' => [
        'activities' => [
            'model' => 'Activity', 'title' => 'Activity', 'icon' => 'check',
            'columns' => [['lead_id','fkreq:Lead'],['type','default:Call'],['summary','string'],['due_at','datetime'],['done','bool']],
            'fillable' => ['lead_id','type','summary','due_at','done'],
            'validation' => ['lead_id'=>'required|exists:leads,id','type'=>'required|in:Call,Meeting,Email,Note','summary'=>'required|string|max:255','due_at'=>'required|date','done'=>'nullable|boolean'],
            'fields' => [
                ['lead_id','Lead','select','@Lead:title',true], ['type','Type','select',['Call','Meeting','Email','Note'],true],
                ['summary','Summary','text',null,true], ['due_at','Due At','datetime-local',null,true],
                ['done','Done?','select',[0=>'No',1=>'Yes']],
            ],
            'with' => ['lead'],
            'rels' => ['lead' => 'belongsTo:Lead'],
            'cols' => [
                'Lead' => '<strong>{{ $r->lead->title }}</strong>', 'Type' => '<span class="badge">{{ $r->type }}</span>',
                'Summary' => '{{ $r->summary }}', 'Due' => '{{ $r->due_at }}',
                'Done' => '{{ $r->done ? "✓" : "—" }}',
            ],
        ],
        'products' => [
            'model' => 'Product', 'title' => 'Product', 'icon' => 'grid',
            'columns' => [['name','string'],['sku','stringNullable'],['price','decimal'],['status','statusActive']],
            'fillable' => ['name','sku','price','status'],
            'validation' => ['name'=>'required|string|max:255','sku'=>'nullable|string','price'=>'required|numeric|min:0','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Product','text',null,true], ['sku','SKU','text'],
                ['price','Price (₹)','number',null,true], ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Product' => '<strong>{{ $r->name }}</strong>', 'SKU' => '{{ $r->sku }}',
                'Price' => '₹{{ number_format($r->price) }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'quotes' => [
            'model' => 'Quote', 'title' => 'Quote', 'icon' => 'receipt',
            'columns' => [['quote_no','stringNullable'],['deal_id','fkreq:Deal'],['title','string'],['amount','decimal'],['valid_until','date'],['status','default:Draft']],
            'fillable' => ['quote_no','deal_id','title','amount','valid_until','status'],
            'validation' => ['deal_id'=>'required|exists:deals,id','title'=>'required|string|max:255','amount'=>'required|numeric|min:0','valid_until'=>'required|date','status'=>'required|in:Draft,Sent,Accepted,Rejected'],
            'store_extra' => "\$data['quote_no'] = 'QT-' . str_pad((string)(\\App\\Models\\Quote::max('id') + 1001), 4, '0', STR_PAD_LEFT);",
            'fields' => [
                ['deal_id','Deal','select','@Deal:title',true], ['title','Quote Title','text',null,true],
                ['amount','Amount (₹)','number',null,true], ['valid_until','Valid Until','date',null,true],
                ['status','Status','select',['Draft','Sent','Accepted','Rejected']],
            ],
            'with' => ['deal'],
            'rels' => ['deal' => 'belongsTo:Deal'],
            'cols' => [
                'Quote' => '<strong>{{ $r->quote_no }} — {{ $r->title }}</strong>', 'Deal' => '{{ $r->deal->title ?? "—" }}',
                'Amount' => '₹{{ number_format($r->amount) }}', 'Valid' => '{{ $r->valid_until }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
    ],
    'seed' => [
        'Activity' => [
            ['lead_id'=>1,'type'=>'Call','summary'=>'Intro call — interested in annual plan','due_at'=>'2026-11-20 15:00','done'=>0],
            ['lead_id'=>2,'type'=>'Meeting','summary'=>'Onsite demo scheduled','due_at'=>'2026-11-22 11:00','done'=>0],
        ],
        'Product' => [
            ['name'=>'SaaS License — Annual','sku'=>'SAA-ANNUAL','price'=>120000,'status'=>'Active'],
            ['name'=>'Implementation Package','sku'=>'IMPL-PKG','price'=>45000,'status'=>'Active'],
        ],
        'Quote' => [
            ['deal_id'=>1,'title'=>'Annual license + onboarding','amount'=>165000,'valid_until'=>'2026-12-31','status'=>'Sent'],
        ],
    ],
];
