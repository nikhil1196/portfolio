<?php
// AI Support — customers + satisfaction ratings
return [
    'base_tables' => ['SupportTicket' => 'tickets'],
    'nav' => [
        ['Customers', 'customers.index', 'users'],
        ['Ratings', 'ratings.index', 'star'],
    ],
    'modules' => [
        'customers' => [
            'model' => 'Customer', 'title' => 'Customer', 'icon' => 'users',
            'columns' => [['name','string'],['email','stringNullable'],['phone','stringNullable'],['company','stringNullable'],['status','statusActive']],
            'fillable' => ['name','email','phone','company','status'],
            'validation' => ['name'=>'required|string|max:255','email'=>'nullable|email','phone'=>'nullable|string','company'=>'nullable|string','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Customer','text',null,true], ['email','Email','email'],
                ['phone','Phone','tel'], ['company','Company','text'],
                ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Name' => '<strong>{{ $r->name }}</strong>', 'Email' => '{{ $r->email }}',
                'Company' => '{{ $r->company }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'ratings' => [
            'model' => 'Rating', 'title' => 'Satisfaction Rating', 'icon' => 'star',
            'columns' => [['ticket_id','fkreq:SupportTicket:ticket_id'],['score','integer'],['feedback','textNullable'],['rated_at','datetime']],
            'fillable' => ['ticket_id','score','feedback','rated_at'],
            'validation' => ['ticket_id'=>'required|exists:tickets,id','score'=>'required|integer|min:1|max:5','feedback'=>'nullable|string','rated_at'=>'required|date'],
            'fields' => [
                ['ticket_id','Ticket','select','@SupportTicket:subject',true], ['score','Score (1–5)','select',[1=>'1 ★',2=>'2 ★',3=>'3 ★',4=>'4 ★',5=>'5 ★'],true],
                ['rated_at','Rated At','datetime-local',null,true], ['feedback','Feedback','textarea'],
            ],
            'with' => ['ticket'],
            'rels' => ['ticket' => 'belongsTo:SupportTicket'],
            'cols' => [
                'Ticket' => '<strong>{{ $r->ticket->subject }}</strong>', 'Score' => '{{ str_repeat("★", $r->score) }}',
                'Feedback' => '{{ Str::limit($r->feedback, 60) }}', 'Rated' => '{{ $r->rated_at }}',
            ],
        ],
    ],
    'seed' => [
        'Customer' => [
            ['name'=>'Kiran Patel','email'=>'kiran@customer.demo','phone'=>'9876001122','company'=>'Patel Traders','status'=>'Active'],
            ['name'=>'Lisa Dsouza','email'=>'lisa@customer.demo','phone'=>'9876001133','company'=>'DS Retail','status'=>'Active'],
        ],
        'Rating' => [
            ['ticket_id'=>1,'score'=>5,'feedback'=>'Quick resolution, great bot suggestion','rated_at'=>'2026-11-19 15:30'],
            ['ticket_id'=>2,'score'=>4,'feedback'=>'Helpful agent','rated_at'=>'2026-11-19 16:00'],
        ],
    ],
];
