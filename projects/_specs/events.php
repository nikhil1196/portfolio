<?php
return [
    'name' => 'Event Booking Platform', 'accent' => '#fd79a8', 'icon' => '★',
    'nav' => [
        ['Dashboard', 'dashboard', '⌂'], ['Events', 'events.index', '★'],
        ['Tickets', 'tickets.index', '▤'], ['Bookings', 'bookings.index', '◎'],
        ['Attendees', 'attendees.index', '◉'],
    ],
    'uses' => "use App\\Models\\Booking;\nuse App\\Models\\Event;",
    'stats' => [
        ['Events', "Event::where('status','Published')->count()", 'live'],
        ['Bookings', "Booking::where('status','Confirmed')->count()", 'confirmed'],
        ['Seats Sold', "Booking::where('status','Confirmed')->sum('seats')", 'total'],
        ['Revenue', "'₹'.number_format(Booking::where('status','Confirmed')->sum('amount'))", 'collected'],
    ],
    'dash' => [
        'title' => 'Upcoming Events', 'link' => ['events.index', 'All'],
        'query' => "Event::where('event_date','>=',now())->orderBy('event_date')->limit(6)->get()",
        'cols' => ['Event' => '<strong>{{ $r->title }}</strong>', 'Venue' => '{{ $r->venue }}', 'Date' => '{{ \\Carbon\\Carbon::parse($r->event_date)->format(\'d M Y\') }}', 'Price' => '{{ $r->price ? "₹".number_format($r->price) : "Free" }}', 'Capacity' => '{{ $r->capacity }}'],
        'empty' => 'No upcoming events',
    ],
    'modules' => [
        'events' => [
            'model' => 'Event', 'title' => 'Event', '_mid' => 1,
            'columns' => [['title','string'],['category','stringNullable'],['venue','stringNullable'],['event_date','datetime'],['price','decimal'],['capacity','integer'],['status','default:Published']],
            'fillable' => ['title','category','venue','event_date','price','capacity','status'],
            'validation' => ['title'=>'required|string|max:255','category'=>'nullable|string','venue'=>'nullable|string','event_date'=>'required|date','price'=>'nullable|numeric|min:0','capacity'=>'nullable|integer|min:0','status'=>'required|in:Published,Draft,Cancelled'],
            'fields' => [
                ['title','Event Title','text',null,true],
                ['category','Category','select',['Tech','Concert','Business','Workshop','Sports','Other']],
                ['venue','Venue','text'], ['event_date','Date & Time','datetime-local',null,true],
                ['price','Base Price (₹)','number'], ['capacity','Capacity','number'],
                ['status','Status','select',['Published','Draft','Cancelled']],
            ],
            'cols' => [
                'Event' => '<strong>{{ $r->title }}</strong><br><span class="note">{{ $r->category }}</span>',
                'Venue' => '{{ $r->venue }}', 'Date' => '{{ \\Carbon\\Carbon::parse($r->event_date)->format(\'d M Y, h:i A\') }}',
                'Price' => '{{ $r->price ? "₹".number_format($r->price) : "Free" }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'tickets' => [
            'model' => 'Ticket', 'title' => 'Ticket Tier', '_mid' => 2,
            'columns' => [['event_id','fkreq:Event'],['name','string'],['price','decimal'],['qty','integer']],
            'fillable' => ['event_id','name','price','qty'],
            'validation' => ['event_id'=>'required|exists:events,id','name'=>'required|string|max:255','price'=>'required|numeric|min:0','qty'=>'required|integer|min:1'],
            'fields' => [
                ['event_id','Event','select','@Event:title',true], ['name','Tier Name','text',null,true],
                ['price','Price (₹)','number',null,true], ['qty','Quantity','number',null,true],
            ],
            'with' => ['event'],
            'rels' => ['event' => 'belongsTo:Event'],
            'cols' => [
                'Event' => '{{ $r->event->title ?? "—" }}', 'Tier' => '<strong>{{ $r->name }}</strong>',
                'Price' => '₹{{ number_format($r->price) }}', 'Qty' => '{{ $r->qty }}',
            ],
        ],
        'bookings' => [
            'model' => 'Booking', 'title' => 'Booking', '_mid' => 3,
            'columns' => [['booking_no','stringNullable'],['event_id','fkreq:Event'],['name','string'],['email','stringNullable'],['seats','integer'],['amount','decimal'],['status','default:Confirmed']],
            'fillable' => ['booking_no','event_id','name','email','seats','amount','status'],
            'validation' => ['event_id'=>'required|exists:events,id','name'=>'required|string|max:255','email'=>'nullable|email','seats'=>'required|integer|min:1','amount'=>'nullable|numeric|min:0','status'=>'required|in:Confirmed,Cancelled,Refunded'],
            'fields' => [
                ['event_id','Event','select','@Event:title',true], ['name','Booked By','text',null,true],
                ['email','Email','email'], ['seats','Seats','number',null,true], ['amount','Amount (₹)','number'],
                ['status','Status','select',['Confirmed','Cancelled','Refunded']],
            ],
            'store_extra' => "        \$data['booking_no'] = 'BKG-' . str_pad((string)(\\App\\Models\\Booking::max('id') + 5001), 4, '0', STR_PAD_LEFT);",
            'with' => ['event'],
            'rels' => ['event' => 'belongsTo:Event', 'attendees' => 'hasMany:Attendee'],
            'cols' => [
                'Booking' => '<code>{{ $r->booking_no }}</code>', 'Event' => '{{ $r->event->title ?? "—" }}',
                'By' => '<strong>{{ $r->name }}</strong>', 'Seats' => '{{ $r->seats }}',
                'Amount' => '₹{{ number_format($r->amount) }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'attendees' => [
            'model' => 'Attendee', 'title' => 'Attendee', '_mid' => 4,
            'columns' => [['booking_id','fkreq:Booking'],['name','string'],['checked_in','bool']],
            'fillable' => ['booking_id','name','checked_in'],
            'validation' => ['booking_id'=>'required|exists:bookings,id','name'=>'required|string|max:255','checked_in'=>'nullable|boolean'],
            'fields' => [
                ['booking_id','Booking','select','@Booking:booking_no',true], ['name','Attendee Name','text',null,true],
                ['checked_in','Checked In','select',[0=>'No',1=>'Yes']],
            ],
            'with' => ['booking.event'],
            'rels' => ['booking' => 'belongsTo:Booking'],
            'cols' => [
                'Name' => '<strong>{{ $r->name }}</strong>', 'Booking' => '<code>{{ $r->booking->booking_no ?? "—" }}</code>',
                'Event' => '{{ $r->booking->event->title ?? "—" }}',
                'Check-in' => '<span class="badge">{{ $r->checked_in ? "Checked In" : "Not Yet" }}</span>',
            ],
        ],
    ],
    'seed' => [
        'Event' => [
            ['title'=>'Laravel Meetup Vadodara','category'=>'Tech','venue'=>'Sayaji Convention Center','event_date'=>'2026-12-14 10:00','price'=>0,'capacity'=>150,'status'=>'Published'],
            ['title'=>'Indie Music Night','category'=>'Concert','venue'=>'Open Air Amphitheatre','event_date'=>'2026-12-21 19:00','price'=>499,'capacity'=>500,'status'=>'Published'],
            ['title'=>'Startup Founders Summit','category'=>'Business','venue'=>'Grand Meridian Hotel','event_date'=>'2027-01-10 09:00','price'=>1999,'capacity'=>200,'status'=>'Published'],
            ['title'=>'Kids Art Workshop','category'=>'Workshop','venue'=>'Creative Studio Space','event_date'=>'2026-12-07 11:00','price'=>350,'capacity'=>40,'status'=>'Published'],
        ],
        'Ticket' => [
            ['event_id'=>2,'name'=>'General Admission','price'=>499,'qty'=>400],
            ['event_id'=>2,'name'=>'VIP','price'=>1499,'qty'=>100],
            ['event_id'=>3,'name'=>'Early Bird','price'=>1499,'qty'=>50],
            ['event_id'=>4,'name'=>'Single Seat','price'=>350,'qty'=>40],
        ],
        'Booking' => [
            ['booking_no'=>'BKG-5001','event_id'=>2,'name'=>'Aditya Verma','email'=>'aditya@example.com','seats'=>2,'amount'=>998,'status'=>'Confirmed'],
            ['booking_no'=>'BKG-5002','event_id'=>3,'name'=>'Nidhi Saxena','email'=>'nidhi@example.com','seats'=>1,'amount'=>1499,'status'=>'Confirmed'],
            ['booking_no'=>'BKG-5003','event_id'=>2,'name'=>'Rahul Dube','email'=>'rahul@example.com','seats'=>4,'amount'=>1996,'status'=>'Confirmed'],
        ],
        'Attendee' => [
            ['booking_id'=>1,'name'=>'Aditya Verma','checked_in'=>0],
            ['booking_id'=>2,'name'=>'Nidhi Saxena','checked_in'=>0],
            ['booking_id'=>3,'name'=>'Rahul Dube','checked_in'=>0],
        ],
    ],
];
