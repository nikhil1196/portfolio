<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);

$total   = table_count($app, 'members');
$active  = table_count($app, 'members', "status='Active'");
$revenue = qv($app, "SELECT COALESCE(SUM(amount),0) FROM payments WHERE status='Paid' AND strftime('%Y-%m', paid_at)=strftime('%Y-%m','now')");
$today   = table_count($app, 'attendance', "date(check_in)=date('now')");
$recent  = qa($app, "SELECT m.*, p.name AS plan FROM members m LEFT JOIN plans p ON p.id=m.plan_id ORDER BY m.id DESC LIMIT 6");
$inGym   = qa($app, "SELECT a.*, m.name FROM attendance a JOIN members m ON m.id=a.member_id WHERE a.check_out IS NULL ORDER BY a.check_in DESC");

page_head($app, 'Dashboard');
?>
<div class="stats-row">
    <?php stat_card('Total Members', $total, 'all registrations'); ?>
    <?php stat_card('Active Members', $active, 'currently subscribed'); ?>
    <?php stat_card('Revenue (Month)', money($revenue), 'collected payments'); ?>
    <?php stat_card("Today's Check-ins", $today, 'attendance marked'); ?>
</div>

<div class="two-col">
    <div class="card">
        <div class="card-head"><h2>Recent Members</h2><a class="btn btn-sm" href="members.php">View all</a></div>
        <div class="card-body" style="padding:0;">
            <table class="tbl">
                <tr><th>Name</th><th>Plan</th><th>Status</th></tr>
                <?php foreach ($recent as $m): ?>
                    <tr><td><?= h($m['name']) ?></td><td><?= h($m['plan'] ?? '—') ?></td><td><?= status_badge($m['status']) ?></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-head"><h2>Currently In Gym</h2><a class="btn btn-sm" href="attendance.php">Attendance</a></div>
        <div class="card-body" style="padding:0;">
            <table class="tbl">
                <tr><th>Member</th><th>Checked In</th></tr>
                <?php if (!$inGym): ?><tr><td colspan="2" class="empty">No one checked in right now</td></tr><?php endif; ?>
                <?php foreach ($inGym as $a): ?>
                    <tr><td><?= h($a['name']) ?></td><td><?= h(dt($a['check_in'], 'd M, h:i A')) ?></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<?php page_foot(); ?>
