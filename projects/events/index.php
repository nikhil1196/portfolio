<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
page_head($app, 'Dashboard');
$upcoming = qa($app, "SELECT e.*, (SELECT COUNT(*) FROM bookings b WHERE b.event_id=e.id AND b.status='Confirmed') AS booked FROM events e WHERE e.event_date>=datetime('now') ORDER BY e.event_date LIMIT 6");
?>
<div class="stats-row">
    <?php stat_card('Events', table_count($app, 'events', "status='Published'"), 'live'); ?>
    <?php stat_card('Bookings', table_count($app, 'bookings', "status='Confirmed'"), 'confirmed'); ?>
    <?php stat_card('Seats Sold', qv($app, "SELECT COALESCE(SUM(seats),0) FROM bookings WHERE status='Confirmed'"), 'total'); ?>
    <?php stat_card('Revenue', money(qv($app, "SELECT COALESCE(SUM(amount),0) FROM bookings WHERE status='Confirmed'")), 'collected'); ?>
</div>
<div class="card"><div class="card-head"><h2>Upcoming Events</h2><a class="btn btn-sm" href="events.php">All</a></div>
<div class="card-body" style="padding:0"><table class="tbl">
<tr><th>Event</th><th>Venue</th><th>Date</th><th>Price</th><th>Booked</th></tr>
<?php foreach ($upcoming as $e): ?><tr><td><strong><?= h($e['title']) ?></strong></td><td><?= h($e['venue']) ?></td><td><?= h(dt($e['event_date'], 'd M Y')) ?></td><td><?= $e['price'] ? money($e['price']) : 'Free' ?></td><td><?= h($e['booked']) ?> / <?= h($e['capacity']) ?></td></tr><?php endforeach; ?>
</table></div></div>
<?php page_foot(); ?>
