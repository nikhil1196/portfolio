<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
auth_require($app);
page_head($app, 'Dashboard');
$recent = qa($app, "SELECT s.*, c.name AS class, c.section FROM students s LEFT JOIN classes c ON c.id=s.class_id ORDER BY s.id DESC LIMIT 8");
?>
<div class="stats-row">
    <?php stat_card('Students', table_count($app, 'students', "status='Active'"), 'enrolled'); ?>
    <?php stat_card('Teachers', table_count($app, 'teachers'), 'on staff'); ?>
    <?php stat_card('Classes', table_count($app, 'classes'), 'sections'); ?>
    <?php stat_card('Fees Collected', money(qv($app, "SELECT COALESCE(SUM(amount),0) FROM fees WHERE status='Paid'")), 'this year'); ?>
</div>
<div class="card"><div class="card-head"><h2>Recent Admissions</h2><a class="btn btn-sm" href="students.php">All students</a></div>
<div class="card-body" style="padding:0"><table class="tbl">
<tr><th>Roll No</th><th>Student</th><th>Class</th><th>Guardian</th><th>Status</th></tr>
<?php foreach ($recent as $s): ?><tr><td><code><?= h($s['roll_no']) ?></code></td><td><strong><?= h($s['name']) ?></strong></td><td><?= h(trim(($s['class'] ?? '') . ' ' . ($s['section'] ?? ''))) ?: '—' ?></td><td><?= h($s['guardian']) ?></td><td><?= status_badge($s['status']) ?></td></tr><?php endforeach; ?>
</table></div></div>
<?php page_foot(); ?>
