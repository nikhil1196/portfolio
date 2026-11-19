<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
page_head($app, 'Dashboard');
$open = qa($app, "SELECT c.*, r.name AS resident, u.flat_no FROM complaints c
    LEFT JOIN residents r ON r.id=c.resident_id LEFT JOIN units u ON u.id=r.unit_id
    WHERE c.status!='Resolved' ORDER BY c.id DESC LIMIT 8");
?>
<div class="stats-row">
    <?php stat_card('Units', table_count($app, 'units'), 'total flats'); ?>
    <?php stat_card('Residents', table_count($app, 'residents'), 'registered'); ?>
    <?php stat_card('Maintenance Due', money(qv($app, "SELECT COALESCE(SUM(amount),0) FROM maintenance WHERE status='Due'")), 'outstanding'); ?>
    <?php stat_card('Open Complaints', table_count($app, 'complaints', "status='Open'"), 'need action'); ?>
</div>
<div class="card"><div class="card-head"><h2>Active Complaints</h2><a class="btn btn-sm" href="complaints.php">All</a></div>
<div class="card-body" style="padding:0"><table class="tbl">
<tr><th>Flat</th><th>Resident</th><th>Subject</th><th>Category</th><th>Status</th></tr>
<?php if (!$open): ?><tr><td colspan="5" class="empty">No open complaints</td></tr><?php endif; ?>
<?php foreach ($open as $c): ?><tr><td><?= h($c['flat_no']) ?></td><td><strong><?= h($c['resident']) ?></strong></td><td><?= h($c['subject']) ?></td><td><?= h($c['category']) ?></td><td><?= status_badge($c['status']) ?></td></tr><?php endforeach; ?>
</table></div></div>
<?php page_foot(); ?>
