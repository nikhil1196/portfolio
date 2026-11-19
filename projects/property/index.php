<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
page_head($app, 'Dashboard');
$due = qa($app, "SELECT r.*, p.title AS prop, t.name AS tenant FROM rents r
    JOIN leases l ON l.id=r.lease_id JOIN properties p ON p.id=l.property_id JOIN tenants t ON t.id=l.tenant_id
    WHERE r.status='Due' ORDER BY r.month DESC LIMIT 8");
?>
<div class="stats-row">
    <?php stat_card('Properties', table_count($app, 'properties'), 'listed'); ?>
    <?php stat_card('Occupied', table_count($app, 'properties', "status='Occupied'"), 'units'); ?>
    <?php stat_card('Active Leases', table_count($app, 'leases', "status='Active'"), 'running'); ?>
    <?php stat_card('Rent Due', money(qv($app, "SELECT COALESCE(SUM(amount),0) FROM rents WHERE status='Due'")), 'this cycle'); ?>
</div>
<div class="card"><div class="card-head"><h2>Pending Rent</h2><a class="btn btn-sm" href="rents.php">All</a></div>
<div class="card-body" style="padding:0"><table class="tbl">
<tr><th>Property</th><th>Tenant</th><th>Month</th><th>Amount</th><th>Status</th></tr>
<?php if (!$due): ?><tr><td colspan="5" class="empty">All rent collected</td></tr><?php endif; ?>
<?php foreach ($due as $r): ?><tr><td><?= h($r['prop']) ?></td><td><strong><?= h($r['tenant']) ?></strong></td><td><?= h(dt($r['month'] . '-01', 'M Y')) ?></td><td><?= money($r['amount']) ?></td><td><?= status_badge($r['status']) ?></td></tr><?php endforeach; ?>
</table></div></div>
<?php page_foot(); ?>
