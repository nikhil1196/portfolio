<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
page_head($app, 'Dashboard');
$today = qa($app, "SELECT a.*, e.name, e.emp_code FROM attendance a JOIN employees e ON e.id=a.emp_id WHERE a.work_date=date('now') ORDER BY e.name");
?>
<div class="stats-row">
    <?php stat_card('Employees', table_count($app, 'employees', "status='Active'"), 'on roll'); ?>
    <?php stat_card('Departments', table_count($app, 'departments'), 'teams'); ?>
    <?php stat_card('Present Today', table_count($app, 'attendance', "work_date=date('now') AND status='Present'"), 'checked in'); ?>
    <?php stat_card('Pending Leaves', table_count($app, 'leaves', "status='Pending'"), 'awaiting approval'); ?>
</div>
<div class="card"><div class="card-head"><h2>Today's Attendance</h2><a class="btn btn-sm" href="attendance.php">Mark</a></div>
<div class="card-body" style="padding:0"><table class="tbl">
<tr><th>Code</th><th>Employee</th><th>Check-in</th><th>Status</th></tr>
<?php if (!$today): ?><tr><td colspan="4" class="empty">Not marked yet</td></tr><?php endif; ?>
<?php foreach ($today as $a): ?><tr><td><code><?= h($a['emp_code']) ?></code></td><td><strong><?= h($a['name']) ?></strong></td><td><?= h($a['check_in'] ?: '—') ?></td><td><?= status_badge($a['status']) ?></td></tr><?php endforeach; ?>
</table></div></div>
<?php page_foot(); ?>
