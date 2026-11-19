<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);

if (is_post()) {
    csrf_check();
    if (maybe_delete($app, 'members')) {
        flash('Member deleted.');
    } else {
        form_save($app, 'members', ['name','email','phone','plan_id','trainer_id','join_date','status'],
            postv('id') ? (int)postv('id') : null);
        flash('Member saved.');
    }
    redirect('members.php');
}

$plans    = qa($app, "SELECT id, name FROM plans ORDER BY name");
$trainers = qa($app, "SELECT id, name FROM trainers WHERE status='Active' ORDER BY name");
$planOpts = ['' => '— No plan —'] + array_column($plans, 'name', 'id');
$trOpts   = ['' => '— No trainer —'] + array_column($trainers, 'name', 'id');

$edit = getv('edit') ? q1($app, 'SELECT * FROM members WHERE id=?', [(int)getv('edit')]) : [];
$rows = qa($app, "SELECT m.*, p.name AS plan, t.name AS trainer FROM members m
                  LEFT JOIN plans p ON p.id=m.plan_id LEFT JOIN trainers t ON t.id=m.trainer_id
                  ORDER BY m.id DESC");

page_head($app, 'Members');
?>
<div class="card">
    <div class="card-head"><h2><?= $edit ? 'Edit Member' : 'Add Member' ?></h2></div>
    <div class="card-body">
        <?php
        render_form([
            ['name'=>'id','label'=>'','type'=>'hidden'],
            ['name'=>'name','label'=>'Full Name','required'=>true],
            ['name'=>'email','label'=>'Email','type'=>'email'],
            ['name'=>'phone','label'=>'Phone','type'=>'tel'],
            ['name'=>'plan_id','label'=>'Plan','type'=>'select','options'=>$planOpts],
            ['name'=>'trainer_id','label'=>'Trainer','type'=>'select','options'=>$trOpts],
            ['name'=>'join_date','label'=>'Join Date','type'=>'date'],
            ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Inactive'=>'Inactive','Expired'=>'Expired']],
        ], $edit ?: [], $edit ? 'Update Member' : 'Add Member');
        ?>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Members (<?= count($rows) ?>)</h2></div>
    <div class="card-body" style="padding:0;">
        <table class="tbl">
            <tr><th>#</th><th>Name</th><th>Contact</th><th>Plan</th><th>Trainer</th><th>Joined</th><th>Status</th><th></th></tr>
            <?php if (!$rows): ?><tr><td colspan="8" class="empty">No members yet</td></tr><?php endif; ?>
            <?php foreach ($rows as $m): ?>
                <tr>
                    <td><?= $m['id'] ?></td>
                    <td><strong><?= h($m['name']) ?></strong></td>
                    <td><?= h($m['phone']) ?><br><span class="note"><?= h($m['email']) ?></span></td>
                    <td><?= h($m['plan'] ?? '—') ?></td>
                    <td><?= h($m['trainer'] ?? '—') ?></td>
                    <td><?= h(dt($m['join_date'])) ?></td>
                    <td><?= status_badge($m['status']) ?></td>
                    <td><?= row_actions('members.php?edit=' . $m['id'], $m['id']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php page_foot(); ?>
