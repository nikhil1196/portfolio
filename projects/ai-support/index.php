<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
page_head($app, 'Dashboard');
$open = qa($app, "SELECT t.*, a.name AS agent FROM tickets t LEFT JOIN agents a ON a.id=t.agent_id WHERE t.status!='Resolved' ORDER BY t.id DESC LIMIT 8");
?>
<div class="stats-row">
    <?php stat_card('Open Tickets', table_count($app, 'tickets', "status='Open'"), 'need reply'); ?>
    <?php stat_card('In Progress', table_count($app, 'tickets', "status='In Progress'"), 'being handled'); ?>
    <?php stat_card('AI Replies', table_count($app, 'replies', 'is_ai=1'), 'automated'); ?>
    <?php stat_card('KB Articles', table_count($app, 'kb_articles', "status='Published'"), 'self-serve'); ?>
</div>
<div class="card"><div class="card-head"><h2>Ticket Queue</h2><a class="btn btn-sm" href="tickets.php">All tickets</a></div>
<div class="card-body" style="padding:0"><table class="tbl">
<tr><th>Ticket</th><th>Customer</th><th>Subject</th><th>Priority</th><th>Agent</th><th>Status</th></tr>
<?php foreach ($open as $t): ?><tr><td><code><?= h($t['ticket_no']) ?></code></td><td><strong><?= h($t['customer']) ?></strong></td><td><?= h($t['subject']) ?></td><td><?= status_badge($t['priority']) ?></td><td><?= h($t['agent'] ?? '—') ?></td><td><?= status_badge($t['status']) ?></td></tr><?php endforeach; ?>
</table></div></div>
<?php page_foot(); ?>
