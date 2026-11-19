<?php
// Events — categories, venues, sessions/speakers
return [
    'base_tables' => ['Event' => 'events'],
    'nav' => [
        ['Categories', 'categories.index', 'grid'],
        ['Venues', 'venues.index', 'building'],
        ['Sessions', 'sessions.index', 'calendar'],
    ],
    'modules' => [
        'categories' => [
            'model' => 'Category', 'title' => 'Event Category', 'icon' => 'grid',
            'columns' => [['name','string'],['status','statusActive']],
            'fillable' => ['name','status'],
            'validation' => ['name'=>'required|string|max:255','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Category','text',null,true], ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Name' => '<strong>{{ $r->name }}</strong>', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'venues' => [
            'model' => 'Venue', 'title' => 'Venue', 'icon' => 'building',
            'columns' => [['name','string'],['address','stringNullable'],['capacity','integer'],['status','statusActive']],
            'fillable' => ['name','address','capacity','status'],
            'validation' => ['name'=>'required|string|max:255','address'=>'nullable|string','capacity'=>'required|integer|min:1','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Venue','text',null,true], ['address','Address','text'],
                ['capacity','Capacity','number',null,true], ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Venue' => '<strong>{{ $r->name }}</strong>', 'Address' => '{{ $r->address }}',
                'Capacity' => '{{ $r->capacity }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'sessions' => [
            'model' => 'Session', 'table' => 'event_sessions', 'title' => 'Session / Speaker', 'icon' => 'calendar',
            'columns' => [['event_id','fkreq:Event'],['title','string'],['speaker','stringNullable'],['starts_at','datetime'],['ends_at','datetimeNullable'],['room','stringNullable'],['status','default:Scheduled']],
            'fillable' => ['event_id','title','speaker','starts_at','ends_at','room','status'],
            'validation' => ['event_id'=>'required|exists:events,id','title'=>'required|string|max:255','speaker'=>'nullable|string','starts_at'=>'required|date','ends_at'=>'nullable|date','room'=>'nullable|string','status'=>'required|in:Scheduled,Live,Done'],
            'fields' => [
                ['event_id','Event','select','@Event:title',true], ['title','Session Title','text',null,true],
                ['speaker','Speaker','text'], ['starts_at','Starts','datetime-local',null,true],
                ['ends_at','Ends','datetime-local'], ['room','Room / Track','text'],
                ['status','Status','select',['Scheduled','Live','Done']],
            ],
            'with' => ['event'],
            'rels' => ['event' => 'belongsTo:Event'],
            'cols' => [
                'Session' => '<strong>{{ $r->title }}</strong>', 'Event' => '{{ $r->event->title }}',
                'Speaker' => '{{ $r->speaker }}', 'Starts' => '{{ $r->starts_at }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
    ],
    'seed' => [
        'Category' => [
            ['name'=>'Conference','status'=>'Active'], ['name'=>'Workshop','status'=>'Active'], ['name'=>'Concert','status'=>'Active'],
        ],
        'Venue' => [
            ['name'=>'Grand Convention Center','address'=>'SG Highway','capacity'=>1200,'status'=>'Active'],
            ['name'=>'Riverside Hall','address'=>'Riverfront','capacity'=>400,'status'=>'Active'],
        ],
        'Session' => [
            ['event_id'=>1,'title'=>'Opening Keynote','speaker'=>'Nikhil Agrawal','starts_at'=>'2026-12-05 09:30','ends_at'=>'2026-12-05 10:30','room'=>'Main Hall','status'=>'Scheduled'],
            ['event_id'=>1,'title'=>'Laravel Performance Workshop','speaker'=>'Guest Speaker','starts_at'=>'2026-12-05 14:00','ends_at'=>'2026-12-05 16:00','room'=>'Track B','status'=>'Scheduled'],
        ],
    ],
];
