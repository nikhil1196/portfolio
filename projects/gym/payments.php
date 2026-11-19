<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);

if (is_post()) {
    csrf_check();
    if (maybe_delete($app, 'payments')) {
        flash('Payment deleted.');
    } else {
        $inv = 'INV-' . str_pad((string)(qv($app, 'SELECT COALESCE(MAX(id),0) FROM payments') + 1001), 4, '0', STR_PAD_LEFT);
        q($app, 'INSERT INTO payments (invoice_no, member_id, plan_id, amount, method, status, paid_at)
                 VALUES (?,?,?,?,?,?,date(\'now\',\'localtime\'))',
            [$inv, postv('member_id') ?: null, postv('plan_id') ?: null, (float)postv('amount'),
             postv('method','Cash'), postv('status','Paid')]);
        flash('Payment recorded — ' . $inv);
    }
    redirect('payments.php');
}

$members  = qa($app, "SELECT id, name FROM members ORDER BY name");
$plans    = qa($app, "SELECT id, name, price FROM plans WHERE status='Active' ORDER BY name");
$memOpts  = ['' => '— Member —'] + array_column($members, 'name', 'id');
$planOpts = ['' => '— Plan —'] + array_column($plans, 'name', 'id');
$rows = qa($app, "SELECT p.*, m.name AS member, pl.name AS plan FROM payments p
                  LEFT JOIN members m ON m.id=p.member_id LEFT JOIN plans pl ON pl.id=p.plan_id
                  ORDER BY p.id DESC LIMIT 60");
$totalPaid = qv($app, "SELECT COALESCE(SUM(amount),0) FROM payments WHERE status='Paid'");

page_head($app, 'Payments');
?>
<div class="card">
    <div class="card-head"><h2>Record Payment</h2><span class="note">Total collected: <strong><?= money($totalPaid) ?></strong></span></div>
    <div class="card-body">
        <?php
        render_form([
            ['name'=>'member_id','label'=>'Member','type'=>'select','options'=>$memOpts,'required'=>true],
            ['name'=>'plan_id','label'=>'Plan','type'=>'select','options'=>$planOpts],
            ['name'=>'amount','label'=>'Amount (₹)','type'=>'number','step'=>'0.01','required'=>true],
            ['name'=>'method','label'=>'Method','type'=>'select','options'=>['Cash'=>'Cash','UPI'=>'UPI','Card'=>'Card','Bank Transfer'=>'Bank Transfer']],
            ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Paid'=>'Paid','Pending'=>'Pending','Due'=>'Due']],
        ], [], 'Record Payment');
        ?>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>Payment History (<?= count($rows) ?>)</h2></div>
    <div class="card-body" style="padding:0;">
        <table class="tbl">
            <tr><th>Invoice</th><th>Member</th><th>Plan</th><th>Amount</th><th>Method</th><th>Date</th><th>Status</th><th></th></tr>
            <?php if (!$rows): ?><tr><td colspan="8" class="empty">No payments yet</td></tr><?php endif; ?>
            <?php foreach ($rows as $p): ?>
                <tr>
                    <td><code><?= h($p['invoice_no']) ?></code></td>
                    <td><strong><?= h($p['member'] ?? '—') ?></strong></td>
                    <td><?= h($p['plan'] ?? '—') ?></td>
                    <td><?= money($p['amount']) ?></td>
                    <td><?= h($p['method']) ?></td>
                    <td><?= h(dt($p['paid_at'])) ?></td>
                    <td><?= status_badge($p['status']) ?></td>
                    <td><?= row_actions('payments.php', $p['id']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php page_foot(); ?>
