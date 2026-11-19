<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);

if (is_post() && postv('checkin_id')) {
    csrf_check();
    q($app, 'UPDATE attendees SET checked_in=1 WHERE id=?', [(int)postv('checkin_id')]);
    flash('Checked in.');
    redirect('attendees.php');
}

$bookings = ['' => '— Booking —'] + array_column(qa($app, 'SELECT id, booking_no FROM bookings ORDER BY id DESC'), 'booking_no', 'id');
crud_page($app, [
    'title' => 'Attendee', 'table' => 'attendees',
    'fields' => [
        ['name'=>'id','label'=>'','type'=>'hidden'],
        ['name'=>'booking_id','label'=>'Booking','type'=>'select','options'=>$bookings,'required'=>true],
        ['name'=>'name','label'=>'Attendee Name','required'=>true],
    ],
    'list_sql' => 'SELECT a.*, b.booking_no, e.title AS event FROM attendees a
                   LEFT JOIN bookings b ON b.id=a.booking_id LEFT JOIN events e ON e.id=b.event_id
                   ORDER BY a.id DESC',
    'columns' => [
        'Name'    => fn($r) => '<strong>' . h($r['name']) . '</strong>',
        'Booking' => fn($r) => '<code>' . h($r['booking_no']) . '</code>',
        'Event'   => fn($r) => h($r['event'] ?? '—'),
        'Check-in'=> fn($r) => $r['checked_in'] ? status_badge('Checked In') :
            '<form method="POST" class="inline">' . csrf_field() . '<input type="hidden" name="checkin_id" value="' . $r['id'] . '"><button class="btn btn-sm" type="submit">Check In</button></form>',
    ],
]);
