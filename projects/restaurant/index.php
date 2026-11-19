<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
page_head($app, 'Dashboard');
$live = qa($app, "SELECT o.*, t.name AS tbl FROM orders o LEFT JOIN tables t ON t.id=o.table_id
    WHERE o.status IN ('Pending','Preparing','Ready') ORDER BY o.created_at");
?>
<div class="stats-row">
    <?php stat_card("Today's Orders", table_count($app, 'orders', "date(created_at)=date('now','localtime')"), 'placed'); ?>
    <?php stat_card('Live Orders', table_count($app, 'orders', "status IN ('Pending','Preparing','Ready')"), 'in kitchen'); ?>
    <?php stat_card("Today's Revenue", money(qv($app, "SELECT COALESCE(SUM(total),0) FROM orders WHERE payment='Paid' AND date(created_at)=date('now','localtime')")), 'collected'); ?>
    <?php stat_card('Menu Items', table_count($app, 'menu_items', 'available=1'), 'available'); ?>
</div>
<div class="card"><div class="card-head"><h2>Live Orders</h2><a class="btn btn-sm" href="kitchen.php">Open Kitchen Display</a></div>
<div class="card-body" style="padding:0"><table class="tbl">
<tr><th>Order</th><th>Table</th><th>Placed</th><th>Total</th><th>Status</th></tr>
<?php if (!$live): ?><tr><td colspan="5" class="empty">No live orders</td></tr><?php endif; ?>
<?php foreach ($live as $o): ?><tr><td><code><?= h($o['order_no']) ?></code></td><td><?= h($o['tbl'] ?? '—') ?></td><td><?= h(dt($o['created_at'], 'h:i A')) ?></td><td><?= money($o['total']) ?></td><td><?= status_badge($o['status']) ?></td></tr><?php endforeach; ?>
</table></div></div>
<?php page_foot(); ?>
