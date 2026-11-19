<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
page_head($app, 'Dashboard');
$pipeline = qa($app, 'SELECT stage, COUNT(*) c, COALESCE(SUM(value),0) v FROM leads GROUP BY stage ORDER BY c DESC');
$open = qa($app, "SELECT t.*, c.name AS contact FROM tasks t LEFT JOIN contacts c ON c.id=t.contact_id WHERE t.status='Open' ORDER BY t.due_date LIMIT 8");
?>
<div class="stats-row">
    <?php stat_card('Contacts', table_count($app, 'contacts'), 'in database'); ?>
    <?php stat_card('Open Leads', table_count($app, 'leads', "stage NOT IN ('Won','Lost')"), 'in pipeline'); ?>
    <?php stat_card('Pipeline Value', money(qv($app, "SELECT COALESCE(SUM(value),0) FROM deals WHERE status='Open'")), 'open deals'); ?>
    <?php stat_card('Deals Won', money(qv($app, "SELECT COALESCE(SUM(value),0) FROM deals WHERE stage='Won'")), 'closed'); ?>
</div>
<div class="two-col">
<div class="card"><div class="card-head"><h2>Lead Pipeline</h2></div><div class="card-body" style="padding:0"><table class="tbl">
<tr><th>Stage</th><th>Leads</th><th>Value</th></tr>
<?php foreach ($pipeline as $p): ?><tr><td><?= status_badge($p['stage']) ?></td><td><?= h($p['c']) ?></td><td><?= money($p['v']) ?></td></tr><?php endforeach; ?>
</table></div></div>
<div class="card"><div class="card-head"><h2>Upcoming Tasks</h2><a class="btn btn-sm" href="tasks.php">All</a></div><div class="card-body" style="padding:0"><table class="tbl">
<tr><th>Task</th><th>Contact</th><th>Due</th><th>Priority</th></tr>
<?php if (!$open): ?><tr><td colspan="4" class="empty">All caught up</td></tr><?php endif; ?>
<?php foreach ($open as $t): ?><tr><td><strong><?= h($t['title']) ?></strong></td><td><?= h($t['contact'] ?? '—') ?></td><td><?= dt($t['due_date']) ?></td><td><?= status_badge($t['priority']) ?></td></tr><?php endforeach; ?>
</table></div></div>
</div>
<?php page_foot(); ?>
