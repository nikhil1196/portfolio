<?php
return array (
  'Category' => 
  array (
    0 => 
    array (
      'name' => 'Starters',
      'sort' => 1,
      'status' => 'Active',
    ),
    1 => 
    array (
      'name' => 'Main Course',
      'sort' => 2,
      'status' => 'Active',
    ),
    2 => 
    array (
      'name' => 'Beverages',
      'sort' => 3,
      'status' => 'Active',
    ),
    3 => 
    array (
      'name' => 'Desserts',
      'sort' => 4,
      'status' => 'Active',
    ),
  ),
  'Reservation' => 
  array (
    0 => 
    array (
      'table_id' => 1,
      'name' => 'Amit Shah',
      'phone' => '9876500001',
      'guests' => 4,
      'res_date' => '2026-11-21',
      'res_time' => '19:30',
      'status' => 'Booked',
    ),
    1 => 
    array (
      'table_id' => 3,
      'name' => 'Priya Mehta',
      'phone' => '9876500002',
      'guests' => 2,
      'res_date' => '2026-11-19',
      'res_time' => '20:00',
      'status' => 'Seated',
    ),
  ),
  'InventoryItem' => 
  array (
    0 => 
    array (
      'name' => 'Basmati Rice',
      'unit' => 'kg',
      'qty' => 40,
      'reorder_level' => 10,
      'supplier' => 'GrainMart',
      'status' => 'Active',
    ),
    1 => 
    array (
      'name' => 'Paneer',
      'unit' => 'kg',
      'qty' => 8,
      'reorder_level' => 5,
      'supplier' => 'FreshDairy',
      'status' => 'Active',
    ),
    2 => 
    array (
      'name' => 'Cooking Oil',
      'unit' => 'ltr',
      'qty' => 15,
      'reorder_level' => 5,
      'supplier' => 'OilCo',
      'status' => 'Active',
    ),
  ),
);
