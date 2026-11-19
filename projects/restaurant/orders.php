<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);

if (is_post()) {
    csrf_check();
    if (postv('pay_id')) {
        q($app, "UPDATE orders SET payment='Paid', status='Served' WHERE id=?", [(int)postv('pay_id')]);
        flash('Payment settled.');
        redirect('orders.php');
    }
    $items = qa($app, 'SELECT id, name, price FROM menu_items WHERE available=1');
    $total = 0;
    $lines = [];
    foreach ($items as $it) {
        $qty = (int)($_POST['qty'][$it['id']] ?? 0);
        if ($qty > 0) { $lines[] = [$it['name'], $qty, $it['price']]; $total += $qty * $it['price']; }
    }
    if ($lines && postv('table_id')) {
        $no = 'ORD-' . str_pad((string)(qv($app, 'SELECT COALESCE(MAX(id),0) FROM orders') + 1001), 4, '0', STR_PAD_LEFT);
        q($app, "INSERT INTO orders (order_no, table_id, status, total) VALUES (?,?,'Pending',?)",
            [$no, (int)postv('table_id'), $total]);
        $oid = (int)$app['db']->lastInsertId();
        foreach ($lines as $l) q($app, 'INSERT INTO order_items (order_id, item_name, qty, price) VALUES (?,?,?,?)', array_merge([$oid], $l));
        q($app, "UPDATE tables SET status='Occupied' WHERE id=?", [(int)postv('table_id')]);
        flash("Order $no sent to kitchen.");
    } else {
        flash('Select a table and at least one item.', 'err');
    }
    redirect('orders.php');
}

$items  = qa($app, 'SELECT * FROM menu_items WHERE available=1 ORDER BY category, name');
$tables = qa($app, "SELECT * FROM tables WHERE status='Free' ORDER BY name");
$orders = qa($app, 'SELECT o.*, t.name AS tbl FROM orders o LEFT JOIN tables t ON t.id=o.table_id ORDER BY o.id DESC LIMIT 25');
$byCat  = [];
foreach ($items as $it) $byCat[$it['category']][] = $it;

page_head($app, 'New Order');
?>
<div class="card"><div class="card-head"><h2>Place Order</h2></div><div class="card-body">
<form method="POST">
    <?= csrf_field() ?>
    <div class="form-row" style="max-width:280px;">
        <label>Table</label>
        <select name="table_id" required>
            <option value="">— Free tables —</option>
            <?php foreach ($tables as $t): ?><option value="<?= $t['id'] ?>"><?= h($t['name']) ?> (<?= $t['seats'] ?> seats)</option><?php endforeach; ?>
        </select>
    </div>
    <?php foreach ($byCat as $cat => $list): ?>
        <h3 style="margin:1rem 0 .5rem;"><?= h($cat) ?></h3>
        <div class="menu-grid">
            <?php foreach ($list as $it): ?>
                <div class="menu-item">
                    <span><?= h($it['name']) ?><br><b><?= money($it['price']) ?></b></span>
                    <input type="number" name="qty[<?= $it['id'] ?>]" min="0" max="20" value="0" aria-label="Qty">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    <button class="btn btn-acc" type="submit" style="margin-top:1rem;">Send to Kitchen</button>
</form>
</div></div>

<div class="card"><div class="card-head"><h2>Recent Orders</h2></div><div class="card-body" style="padding:0">
<table class="tbl">
<tr><th>Order</th><th>Table</th><th>Items</th><th>Total</th><th>Status</th><th>Payment</th><th></th></tr>
<?php foreach ($orders as $o):
    $cnt = qv($app, 'SELECT COALESCE(SUM(qty),0) FROM order_items WHERE order_id=?', [$o['id']]); ?>
<tr>
    <td><code><?= h($o['order_no']) ?></code></td><td><?= h($o['tbl'] ?? '—') ?></td><td><?= h($cnt) ?></td>
    <td><?= money($o['total']) ?></td><td><?= status_badge($o['status']) ?></td><td><?= status_badge($o['payment']) ?></td>
    <td><?php if ($o['payment'] === 'Unpaid'): ?>
        <form method="POST" class="inline"><?= csrf_field() ?><input type="hidden" name="pay_id" value="<?= $o['id'] ?>"><button class="btn btn-sm" type="submit">Settle</button></form>
    <?php endif; ?></td>
</tr>
<?php endforeach; ?>
</table></div></div>
<?php page_foot(); ?>
