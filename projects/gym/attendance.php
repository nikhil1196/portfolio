<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);

if (is_post()) {
    csrf_check();
    if (postv('checkout_id')) {
        q($app, 'UPDATE attendance SET check_out=datetime(\'now\',\'localtime\') WHERE id=? AND check_out IS NULL',
            [(int)postv('checkout_id')]);
        flash('Checked out.');
    } elseif (postv('member_id')) {
        q($app, 'INSERT INTO attendance (member_id, check_in) VALUES (?, datetime(\'now\',\'localtime\'))',
            [(int)postv('member_id')]);
        flash('Checked in.');
    }
    redirect('attendance.php');
}

$members = qa($app, "SELECT id, name FROM members WHERE status='Active' ORDER BY name");
$rows = qa($app, "SELECT a.*, m.name FROM attendance a JOIN members m ON m.id=a.member_id
                  ORDER BY a.check_in DESC LIMIT 50");

page_head($app, 'Attendance');
?>
<div class="card">
    <div class="card-head"><h2>Member Check-in</h2></div>
    <div class="card-body">
        <form method="POST" class="toolbar">
            <?= csrf_field() ?>
            <select name="member_id" required>
                <option value="">— Select member —</option>
                <?php foreach ($members as $m): ?><option value="<?= $m['id'] ?>"><?= h($m['name']) ?></option><?php endforeach; ?>
            </select>
            <button class="btn btn-acc" type="submit">Check In</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>Attendance Log</h2></div>
    <div class="card-body" style="padding:0;">
        <table class="tbl">
            <tr><th>Member</th><th>Check In</th><th>Check Out</th><th>Status</th><th></th></tr>
            <?php if (!$rows): ?><tr><td colspan="5" class="empty">No attendance records</td></tr><?php endif; ?>
            <?php foreach ($rows as $a): ?>
                <tr>
                    <td><strong><?= h($a['name']) ?></strong></td>
                    <td><?= h(dt($a['check_in'], 'd M, h:i A')) ?></td>
                    <td><?= $a['check_out'] ? h(dt($a['check_out'], 'd M, h:i A')) : '—' ?></td>
                    <td><?= $a['check_out'] ? status_badge('Completed') : status_badge('Present') ?></td>
                    <td>
                        <?php if (!$a['check_out']): ?>
                            <form method="POST" class="inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="checkout_id" value="<?= $a['id'] ?>">
                                <button class="btn btn-sm" type="submit">Check Out</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php page_foot(); ?>
