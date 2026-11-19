<?php
return array (
  'Receipt' => 
  array (
    0 => 
    array (
      'maintenance_id' => 1,
      'unit_id' => 1,
      'amount' => 2500,
      'method' => 'Online',
      'txn_ref' => 'upi_demo_9x2k',
      'status' => 'Paid',
    ),
    1 => 
    array (
      'maintenance_id' => 2,
      'unit_id' => 2,
      'amount' => 2500,
      'method' => 'UPI',
      'txn_ref' => 'upi_demo_7m4p',
      'status' => 'Paid',
    ),
  ),
  'Visitor' => 
  array (
    0 => 
    array (
      'unit_id' => 1,
      'name' => 'Courier - Amazon',
      'phone' => NULL,
      'purpose' => 'Delivery',
      'check_in' => '2026-11-19 10:15',
      'check_out' => '2026-11-19 10:25',
      'status' => 'Left',
    ),
    1 => 
    array (
      'unit_id' => 3,
      'name' => 'Suresh Kumar',
      'phone' => '9822001100',
      'purpose' => 'Family visit',
      'check_in' => '2026-11-19 18:00',
      'check_out' => NULL,
      'status' => 'Inside',
    ),
  ),
  'Staff' => 
  array (
    0 => 
    array (
      'name' => 'Raju Singh',
      'role' => 'Security',
      'phone' => '9811002200',
      'shift' => 'Night',
      'status' => 'Active',
    ),
    1 => 
    array (
      'name' => 'Meena Devi',
      'role' => 'Cleaner',
      'phone' => '9811002211',
      'shift' => 'Morning',
      'status' => 'Active',
    ),
    2 => 
    array (
      'name' => 'PowerFix Services',
      'role' => 'Electrician',
      'phone' => '9811002222',
      'shift' => 'On-call',
      'status' => 'Active',
    ),
  ),
  'Parking' => 
  array (
    0 => 
    array (
      'slot_no' => 'P-01',
      'unit_id' => 1,
      'vehicle_no' => 'GJ06AB1234',
      'vehicle_type' => 'Car',
      'status' => 'Assigned',
    ),
    1 => 
    array (
      'slot_no' => 'P-02',
      'unit_id' => 2,
      'vehicle_no' => 'GJ06CD5678',
      'vehicle_type' => 'Car',
      'status' => 'Assigned',
    ),
    2 => 
    array (
      'slot_no' => 'P-15',
      'unit_id' => NULL,
      'vehicle_no' => NULL,
      'vehicle_type' => 'Car',
      'status' => 'Free',
    ),
  ),
  'family_members' => 
  array (
    0 => 
    array (
      'unit_id' => 1,
      'resident_id' => 1,
      'name' => 'Meena Shah',
      'relation' => 'Spouse',
      'occupation' => 'Teacher',
    ),
    1 => 
    array (
      'unit_id' => 1,
      'resident_id' => 1,
      'name' => 'Aryan Shah',
      'relation' => 'Child',
    ),
  ),
);
