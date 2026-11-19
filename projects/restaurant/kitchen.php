<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);

if (is_post()) {
    csrf_check();
    $flow = ['Pending' => 'Preparing', 'Preparing' => 'Ready', 'Ready' => 'Served'];
    $oid = (int)postv('order_id');
    $cur = qv($app, 'SELECT status FROM orders WHERE id=?', [$oid]);
    if ($oid && isset($flow[$cur])) {
        q($app, 'UPDATE orders SET status=? WHERE id=?', [$flow[$cur], $oid]);
        if ($flow[$cur] === 'Served') q($app, "UPDATE tables SET status='Free' WHERE id=(SELECT table_id FROM orders WHERE id=?)", [$oid]);
        flash("Order moved to {$flow[$cur]}.");
    }
    redirect('kitchen.php');
}

page_head($app, 'Kitchen Display');
$cols = ['Pending' => 'New Orders', 'Preparing' => 'Preparing', 'Ready' => 'Ready to Serve'];
?>
<div class="kds-grid">
<?php foreach ($cols as $status => $label):
    $orders = qa($app, "SELECT o.*, t.name AS tbl FROM orders o LEFT JOIN tables t ON t.id=o.table_id WHERE o.status=? ORDER BY o.created_at", [$status]); ?>
    <div class="kds-col">
        <h2><?= h($label) ?> <span class="badge badge-err"><?= count($orders) ?></span></h2>
        <?php foreach ($orders as $o):
            $its = qa($app, 'SELECT * FROM order_items WHERE order_id=?', [$o['id']]); ?>
            <div class="kds-ticket">
                <div class="kds-head"><strong><?= h($o['order_no']) ?></strong><span><?= h($o['tbl'] ?? '—') ?> · <?= h(dt($o['created_at'], 'h:i A')) ?></span></div>
                <ul><?php foreach ($its as $it): ?><li><?= h($it['qty']) ?> × <?= h($it['item_name']) ?></li><?php endforeach; ?></ul>
                <form method="POST"><?= csrf_field() ?><input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                    <button class="btn btn-acc btn-sm" type="submit"><?= $status === 'Pending' ? 'Start Preparing' : ($status === 'Preparing' ? 'Mark Ready' : 'Mark Served') ?></button>
                </form>
            </div>
        <?php endforeach; ?>
        <?php if (!$orders): ?><p class="empty">Nothing here</p><?php endif; ?>
    </div>
<?php endforeach; ?>
</div>
<?php page_foot(); ?>
