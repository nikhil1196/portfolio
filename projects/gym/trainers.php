<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);

if (is_post()) {
    csrf_check();
    if (maybe_delete($app, 'trainers')) {
        flash('Trainer deleted.');
    } else {
        form_save($app, 'trainers', ['name','specialty','phone','status'],
            postv('id') ? (int)postv('id') : null);
        flash('Trainer saved.');
    }
    redirect('trainers.php');
}

$edit = getv('edit') ? q1($app, 'SELECT * FROM trainers WHERE id=?', [(int)getv('edit')]) : [];
$rows = qa($app, 'SELECT t.*, (SELECT COUNT(*) FROM members m WHERE m.trainer_id=t.id) AS members FROM trainers t ORDER BY t.name');

page_head($app, 'Trainers');
?>
<div class="card">
    <div class="card-head"><h2><?= $edit ? 'Edit Trainer' : 'Add Trainer' ?></h2></div>
    <div class="card-body">
        <?php
        render_form([
            ['name'=>'id','label'=>'','type'=>'hidden'],
            ['name'=>'name','label'=>'Trainer Name','required'=>true],
            ['name'=>'specialty','label'=>'Specialty','placeholder'=>'e.g. Strength & Conditioning'],
            ['name'=>'phone','label'=>'Phone','type'=>'tel'],
            ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Inactive'=>'Inactive']],
        ], $edit ?: [], $edit ? 'Update Trainer' : 'Add Trainer');
        ?>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Trainers (<?= count($rows) ?>)</h2></div>
    <div class="card-body" style="padding:0;">
        <table class="tbl">
            <tr><th>Name</th><th>Specialty</th><th>Phone</th><th>Assigned Members</th><th>Status</th><th></th></tr>
            <?php if (!$rows): ?><tr><td colspan="6" class="empty">No trainers yet</td></tr><?php endif; ?>
            <?php foreach ($rows as $t): ?>
                <tr>
                    <td><strong><?= h($t['name']) ?></strong></td>
                    <td><?= h($t['specialty']) ?></td>
                    <td><?= h($t['phone']) ?></td>
                    <td><?= h($t['members']) ?></td>
                    <td><?= status_badge($t['status']) ?></td>
                    <td><?= row_actions('trainers.php?edit=' . $t['id'], $t['id']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php page_foot(); ?>
