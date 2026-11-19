<?php
// Restaurant — categories, table reservations, inventory stock
return [
    'base_tables' => ['DiningTable' => 'tables', 'MenuItem' => 'menu_items', 'Order' => 'orders'],
    'nav' => [
        ['Categories', 'categories.index', 'grid'],
        ['Reservations', 'reservations.index', 'calendar'],
        ['Inventory', 'inventory.index', 'clipboard'],
    ],
    'modules' => [
        'categories' => [
            'model' => 'Category', 'title' => 'Menu Category', 'icon' => 'grid',
            'columns' => [['name','string'],['sort','integer'],['status','statusActive']],
            'fillable' => ['name','sort','status'],
            'validation' => ['name'=>'required|string|max:255','sort'=>'nullable|integer','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Category','text',null,true], ['sort','Sort Order','number'],
                ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Name' => '<strong>{{ $r->name }}</strong>', 'Sort' => '{{ $r->sort }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'reservations' => [
            'model' => 'Reservation', 'title' => 'Table Reservation', 'icon' => 'calendar',
            'columns' => [['table_id','fkreq:DiningTable:table_id'],['name','string'],['phone','stringNullable'],['guests','integer'],['res_date','date'],['res_time','time'],['status','default:Booked']],
            'fillable' => ['table_id','name','phone','guests','res_date','res_time','status'],
            'validation' => ['table_id'=>'required|exists:tables,id','name'=>'required|string|max:255','phone'=>'nullable|string','guests'=>'required|integer|min:1','res_date'=>'required|date','res_time'=>'required','status'=>'required|in:Booked,Seated,Cancelled,No-show'],
            'fields' => [
                ['table_id','Table','select','@DiningTable:name',true], ['name','Guest Name','text',null,true],
                ['phone','Phone','tel'], ['guests','Guests','number',null,true],
                ['res_date','Date','date',null,true], ['res_time','Time','time',null,true],
                ['status','Status','select',['Booked','Seated','Cancelled','No-show']],
            ],
            'with' => ['table'],
            'rels' => ['table' => 'belongsTo:DiningTable:table_id'],
            'cols' => [
                'Guest' => '<strong>{{ $r->name }}</strong>', 'Table' => '{{ $r->table->name ?? "—" }}',
                'Date' => '{{ $r->res_date }}', 'Time' => '{{ substr($r->res_time,0,5) }}',
                'Guests' => '{{ $r->guests }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'inventory' => [
            'model' => 'InventoryItem', 'title' => 'Inventory Item', 'icon' => 'clipboard', 'table' => 'inventory',
            'columns' => [['name','string'],['unit','default:kg'],['qty','decimal'],['reorder_level','decimal'],['supplier','stringNullable'],['status','statusActive']],
            'fillable' => ['name','unit','qty','reorder_level','supplier','status'],
            'validation' => ['name'=>'required|string|max:255','unit'=>'required|in:kg,g,ltr,ml,pcs,box','qty'=>'required|numeric|min:0','reorder_level'=>'nullable|numeric|min:0','supplier'=>'nullable|string','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Ingredient / Item','text',null,true], ['unit','Unit','select',['kg','g','ltr','ml','pcs','box'],true],
                ['qty','Qty in Stock','number',null,true], ['reorder_level','Reorder Level','number'],
                ['supplier','Supplier','text'], ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Item' => '<strong>{{ $r->name }}</strong>', 'Stock' => '{{ $r->qty }} {{ $r->unit }}',
                'Reorder @' => '{{ $r->reorder_level }}', 'Supplier' => '{{ $r->supplier }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
    ],
    'seed' => [
        'Category' => [
            ['name'=>'Starters','sort'=>1,'status'=>'Active'],
            ['name'=>'Main Course','sort'=>2,'status'=>'Active'],
            ['name'=>'Beverages','sort'=>3,'status'=>'Active'],
            ['name'=>'Desserts','sort'=>4,'status'=>'Active'],
        ],
        'Reservation' => [
            ['table_id'=>1,'name'=>'Amit Shah','phone'=>'9876500001','guests'=>4,'res_date'=>'2026-11-21','res_time'=>'19:30','status'=>'Booked'],
            ['table_id'=>3,'name'=>'Priya Mehta','phone'=>'9876500002','guests'=>2,'res_date'=>'2026-11-19','res_time'=>'20:00','status'=>'Seated'],
        ],
        'InventoryItem' => [
            ['name'=>'Basmati Rice','unit'=>'kg','qty'=>40,'reorder_level'=>10,'supplier'=>'GrainMart','status'=>'Active'],
            ['name'=>'Paneer','unit'=>'kg','qty'=>8,'reorder_level'=>5,'supplier'=>'FreshDairy','status'=>'Active'],
            ['name'=>'Cooking Oil','unit'=>'ltr','qty'=>15,'reorder_level'=>5,'supplier'=>'OilCo','status'=>'Active'],
        ],
    ],
];
