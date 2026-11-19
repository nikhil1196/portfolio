<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
page_head($app, 'Dashboard');
$todays = qa($app, "SELECT a.*, p.name AS patient, d.name AS doctor FROM appointments a
    JOIN patients p ON p.id=a.patient_id JOIN doctors d ON d.id=a.doctor_id
    WHERE a.appt_date=date('now') ORDER BY a.appt_time");
?>
<div class="stats-row">
    <?php stat_card('Patients', table_count($app, 'patients'), 'registered'); ?>
    <?php stat_card('Doctors', table_count($app, 'doctors'), 'on staff'); ?>
    <?php stat_card("Today's Appointments", table_count($app, 'appointments', "appt_date=date('now')"), 'scheduled'); ?>
    <?php stat_card('Revenue (Month)', money(qv($app, "SELECT COALESCE(SUM(amount),0) FROM bills WHERE status='Paid' AND strftime('%Y-%m',paid_at)=strftime('%Y-%m','now')")), 'billed'); ?>
</div>
<div class="card"><div class="card-head"><h2>Today's Appointments</h2><a class="btn btn-sm" href="appointments.php">All</a></div>
<div class="card-body" style="padding:0"><table class="tbl">
<tr><th>Time</th><th>Patient</th><th>Doctor</th><th>Reason</th><th>Status</th></tr>
<?php if (!$todays): ?><tr><td colspan="5" class="empty">Nothing scheduled today</td></tr><?php endif; ?>
<?php foreach ($todays as $a): ?><tr><td><?= h($a['appt_time']) ?></td><td><strong><?= h($a['patient']) ?></strong></td><td><?= h($a['doctor']) ?></td><td><?= h($a['reason']) ?></td><td><?= status_badge($a['status']) ?></td></tr><?php endforeach; ?>
</table></div></div>
<?php page_foot(); ?>
