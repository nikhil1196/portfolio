<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);

if (is_post()) {
    csrf_check();
    if (maybe_delete($app, 'plans')) {
        flash('Plan deleted.');
    } else {
        form_save($app, 'plans', ['name','duration_months','price','features','status'],
            postv('id') ? (int)postv('id') : null);
        flash('Plan saved.');
    }
    redirect('plans.php');
}

$edit = getv('edit') ? q1($app, 'SELECT * FROM plans WHERE id=?', [(int)getv('edit')]) : [];
$rows = qa($app, 'SELECT p.*, (SELECT COUNT(*) FROM members m WHERE m.plan_id=p.id) AS members FROM plans p ORDER BY price');

page_head($app, 'Membership Plans');
?>
<div class="card">
    <div class="card-head"><h2><?= $edit ? 'Edit Plan' : 'Add Plan' ?></h2></div>
    <div class="card-body">
        <?php
        render_form([
            ['name'=>'id','label'=>'','type'=>'hidden'],
            ['name'=>'name','label'=>'Plan Name','required'=>true,'placeholder'=>'e.g. Annual'],
            ['name'=>'duration_months','label'=>'Duration (months)','type'=>'number','required'=>true],
            ['name'=>'price','label'=>'Price (₹)','type'=>'number','step'=>'0.01','required'=>true],
            ['name'=>'features','label'=>'Features','placeholder'=>'Gym + classes + diet plan'],
            ['name'=>'status','label'=>'Status','type'=>'select','options'=>['Active'=>'Active','Inactive'=>'Inactive']],
        ], $edit ?: [], $edit ? 'Update Plan' : 'Add Plan');
        ?>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Plans (<?= count($rows) ?>)</h2></div>
    <div class="card-body" style="padding:0;">
        <table class="tbl">
            <tr><th>Plan</th><th>Duration</th><th>Price</th><th>Features</th><th>Members</th><th>Status</th><th></th></tr>
            <?php if (!$rows): ?><tr><td colspan="7" class="empty">No plans yet</td></tr><?php endif; ?>
            <?php foreach ($rows as $p): ?>
                <tr>
                    <td><strong><?= h($p['name']) ?></strong></td>
                    <td><?= h($p['duration_months']) ?> mo</td>
                    <td><?= money($p['price']) ?></td>
                    <td class="note"><?= h($p['features']) ?></td>
                    <td><?= h($p['members']) ?></td>
                    <td><?= status_badge($p['status']) ?></td>
                    <td><?= row_actions('plans.php?edit=' . $p['id'], $p['id']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php page_foot(); ?>
