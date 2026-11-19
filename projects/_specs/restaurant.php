<?php
return [
    'name' => 'Restaurant POS + KDS', 'accent' => '#d63031', 'icon' => '♨',
    'nav' => [
        ['Dashboard', 'dashboard', 'home'], ['New Order', 'pos', 'grid'],
        ['Kitchen', 'kitchen', 'flame'], ['Orders', 'orders.index', 'receipt'],
        ['Menu', 'menu.index', 'book'], ['Tables', 'tables.index', 'grid'],
    ],
    'uses' => "use App\\Models\\MenuItem;\nuse App\\Models\\Order;",
    'stats' => [
        ["Today's Orders", "Order::whereDate('created_at', today())->count()", 'placed'],
        ['Live Orders', "Order::whereIn('status', ['Pending','Preparing','Ready'])->count()", 'in kitchen'],
        ["Today's Revenue", "'₹'.number_format(Order::where('payment','Paid')->whereDate('created_at', today())->sum('total'))", 'collected'],
        ['Menu Items', "MenuItem::where('available',1)->count()", 'available'],
    ],
    'dash' => [
        'title' => 'Live Orders', 'link' => ['kitchen', 'Open Kitchen Display'],
        'query' => "Order::with('diningTable')->whereIn('status', ['Pending','Preparing','Ready'])->orderBy('created_at')->get()",
        'cols' => ['Order' => '<code>{{ $r->order_no }}</code>', 'Table' => '{{ $r->diningTable->name ?? "—" }}', 'Placed' => '{{ $r->created_at->format(\'h:i A\') }}', 'Total' => '₹{{ number_format($r->total) }}', 'Status' => '<span class="badge">{{ $r->status }}</span>'],
        'empty' => 'No live orders',
    ],
    'extra_models' => [
        [
            'model' => 'OrderItem', 'table' => 'order_items', '_mid' => 4,
            'columns' => [['order_id','fkreq:Order'],['item_name','string'],['qty','integer'],['price','decimal']],
            'fillable' => ['order_id','item_name','qty','price'],
            'rels' => ['order' => 'belongsTo:Order'],
        ],
    ],
    'modules' => [
        'menu' => [
            'model' => 'MenuItem', 'title' => 'Menu Item', 'table' => 'menu_items', '_mid' => 1,
            'columns' => [['name','string'],['category','stringNullable'],['price','decimal'],['available','bool']],
            'fillable' => ['name','category','price','available'],
            'validation' => ['name'=>'required|string|max:255','category'=>'nullable|string','price'=>'required|numeric|min:0','available'=>'nullable|boolean'],
            'fields' => [
                ['name','Item Name','text',null,true],
                ['category','Category','select',['Starters','Breads','Mains','South Indian','Beverages','Desserts']],
                ['price','Price (₹)','number',null,true],
                ['available','Available','select',[1=>'Yes',0=>'No']],
            ],
            'cols' => [
                'Item' => '<strong>{{ $r->name }}</strong>', 'Category' => '{{ $r->category }}',
                'Price' => '₹{{ number_format($r->price) }}',
                'Available' => '<span class="badge">{{ $r->available ? "Yes" : "Sold Out" }}</span>',
            ],
        ],
        'tables' => [
            'model' => 'DiningTable', 'title' => 'Table', 'table' => 'tables', '_mid' => 2,
            'columns' => [['name','string'],['seats','integer'],['status','default:Free']],
            'fillable' => ['name','seats','status'],
            'validation' => ['name'=>'required|string|max:20','seats'=>'nullable|integer|min:1','status'=>'required|in:Free,Occupied,Reserved'],
            'fields' => [
                ['name','Table Name','text',null,true], ['seats','Seats','number'],
                ['status','Status','select',['Free','Occupied','Reserved']],
            ],
            'rels' => ['orders' => 'hasMany:Order:table_id'],
            'cols' => [
                'Table' => '<strong>{{ $r->name }}</strong>', 'Seats' => '{{ $r->seats }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'orders' => [
            'model' => 'Order', 'title' => 'Order', '_mid' => 3,
            'columns' => [['order_no','stringNullable'],['table_id','fk:DiningTable:table_id'],['status','default:Pending'],['total','decimal'],['payment','default:Unpaid']],
            'fillable' => ['order_no','table_id','status','total','payment'],
            'validation' => ['table_id'=>'nullable|exists:tables,id','status'=>'required|in:Pending,Preparing,Ready,Served','total'=>'nullable|numeric|min:0','payment'=>'required|in:Paid,Unpaid'],
            'fields' => [
                ['table_id','Table','select','@DiningTable:name'],
                ['status','Status','select',['Pending','Preparing','Ready','Served']],
                ['total','Total (₹)','number'], ['payment','Payment','select',['Unpaid','Paid']],
            ],
            'with' => ['diningTable', 'items'],
            'rels' => ['diningTable' => 'belongsTo:DiningTable:table_id', 'items' => 'hasMany:OrderItem'],
            'cols' => [
                'Order' => '<code>{{ $r->order_no }}</code>', 'Table' => '{{ $r->diningTable->name ?? "—" }}',
                'Items' => '{{ $r->items->sum("qty") }}', 'Total' => '₹{{ number_format($r->total) }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
                'Payment' => '<span class="badge">{{ $r->payment }}</span>',
            ],
        ],
    ],
    'extra_routes' => "    Route::get('pos', [\\App\\Http\\Controllers\\PosController::class, 'index'])->name('pos');
    Route::post('pos', [\\App\\Http\\Controllers\\PosController::class, 'store'])->name('pos.store');
    Route::post('pos/{order}/settle', [\\App\\Http\\Controllers\\PosController::class, 'settle'])->name('pos.settle');
    Route::get('kitchen', [\\App\\Http\\Controllers\\KitchenController::class, 'index'])->name('kitchen');
    Route::post('kitchen/{order}/advance', [\\App\\Http\\Controllers\\KitchenController::class, 'advance'])->name('kitchen.advance');
",
    'seed' => [
        'MenuItem' => [
            ['name'=>'Paneer Tikka','category'=>'Starters','price'=>240,'available'=>1],
            ['name'=>'Veg Manchurian','category'=>'Starters','price'=>180,'available'=>1],
            ['name'=>'Butter Naan','category'=>'Breads','price'=>50,'available'=>1],
            ['name'=>'Paneer Butter Masala','category'=>'Mains','price'=>280,'available'=>1],
            ['name'=>'Dal Tadka','category'=>'Mains','price'=>190,'available'=>1],
            ['name'=>'Veg Biryani','category'=>'Mains','price'=>220,'available'=>1],
            ['name'=>'Masala Dosa','category'=>'South Indian','price'=>160,'available'=>1],
            ['name'=>'Cold Coffee','category'=>'Beverages','price'=>120,'available'=>1],
            ['name'=>'Gulab Jamun','category'=>'Desserts','price'=>90,'available'=>1],
        ],
        'DiningTable' => [
            ['name'=>'T1','seats'=>2,'status'=>'Occupied'], ['name'=>'T2','seats'=>4,'status'=>'Occupied'],
            ['name'=>'T3','seats'=>4,'status'=>'Free'], ['name'=>'T4','seats'=>6,'status'=>'Free'],
            ['name'=>'T5','seats'=>2,'status'=>'Free'], ['name'=>'T6','seats'=>8,'status'=>'Reserved'],
        ],
        'Order' => [
            ['order_no'=>'ORD-1001','table_id'=>1,'status'=>'Preparing','total'=>710,'payment'=>'Unpaid'],
            ['order_no'=>'ORD-1002','table_id'=>2,'status'=>'Pending','total'=>430,'payment'=>'Unpaid'],
            ['order_no'=>'ORD-1003','table_id'=>3,'status'=>'Served','total'=>520,'payment'=>'Paid'],
        ],
        'OrderItem' => [
            ['order_id'=>1,'item_name'=>'Paneer Tikka','qty'=>1,'price'=>240],
            ['order_id'=>1,'item_name'=>'Butter Naan','qty'=>4,'price'=>50],
            ['order_id'=>1,'item_name'=>'Dal Tadka','qty'=>1,'price'=>190],
            ['order_id'=>2,'item_name'=>'Veg Manchurian','qty'=>1,'price'=>180],
            ['order_id'=>2,'item_name'=>'Paneer Butter Masala','qty'=>1,'price'=>280],
            ['order_id'=>3,'item_name'=>'Masala Dosa','qty'=>2,'price'=>160],
            ['order_id'=>3,'item_name'=>'Cold Coffee','qty'=>2,'price'=>120],
        ],
    ],
];
