<?php
// Hub listing all Laravel demo applications.
function h($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
$meta = [
    'gym'        => ['Gym Management SaaS', 'Members, plans, trainers, attendance, payments', '#6c5ce7'],
    'clinic'     => ['Clinic Management', 'Patients, doctors, appointments, prescriptions, bills', '#00cec9'],
    'school'     => ['School ERP', 'Students, teachers, classes, fees, exam results', '#0984e3'],
    'society'    => ['Society Management', 'Units, residents, maintenance, complaints, notices', '#e17055'],
    'restaurant' => ['Restaurant POS + KDS', 'Menu, tables, POS orders, kitchen display, bills', '#d63031'],
    'hrms'       => ['HRMS', 'Departments, employees, attendance, leaves, payroll', '#00b894'],
    'crm'        => ['CRM', 'Contacts, leads pipeline, deals, follow-up tasks', '#e84393'],
    'property'   => ['Property Management', 'Properties, tenants, leases, rent, requests', '#fdcb6e'],
    'events'     => ['Event Booking', 'Events, ticket tiers, bookings, attendee check-in', '#a29bfe'],
    'ai-support' => ['AI Support Platform', 'Tickets, replies, KB, canned responses, agents', '#55efc4'],
];
$apps = [];
foreach ($meta as $slug => $m) {
    if (is_file(__DIR__ . "/$slug/artisan")) { $apps[$slug] = $m; }
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Demo Applications — Nikhil Agrawal</title>
<link rel="stylesheet" href="_core/assets/admin.css">
<style>
body{background:#0f1117;color:#e8eaf0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem}
.hub{max-width:1100px;width:100%}
.hub h1{font-size:1.8rem;margin-bottom:.3rem}
.hub .sub{opacity:.6;margin-bottom:2rem}
.hub-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1rem}
.hub-card{display:flex;gap:1rem;align-items:center;background:var(--card);border:1px solid var(--border);border-radius:14px;padding:1.1rem 1.25rem;text-decoration:none;color:inherit;transition:.2s}
.hub-card:hover{transform:translateY(-3px);border-color:var(--acc,#6c5ce7)}
.hub-ico{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#fff;flex-shrink:0}
.hub-card h3{margin:0;font-size:1rem}
.hub-card p{margin:.15rem 0 0;font-size:.8rem;opacity:.6}
.demo-note{margin-top:2rem;font-size:.8rem;opacity:.5;text-align:center;line-height:1.8}
.demo-note code{background:rgba(255,255,255,.08);padding:.15rem .45rem;border-radius:6px}
</style>
</head>
<body>
<div class="hub">
    <h1>Demo Applications</h1>
    <p class="sub">Laravel apps built by Nikhil Agrawal · <a href="../portfolio.php" style="color:#a29bfe">← Back to Portfolio</a></p>
    <div class="hub-grid">
        <?php foreach ($apps as $slug => $a): ?>
            <a class="hub-card" href="<?= h($slug) ?>/public/" style="--acc:<?= h($a[2]) ?>">
                <span class="hub-ico" style="background:<?= h($a[2]) ?>">◆</span>
                <span><h3><?= h($a[0]) ?></h3><p><?= h($a[1]) ?></p></span>
            </a>
        <?php endforeach; ?>
    </div>
    <p class="demo-note">
        Each app is a standalone Laravel project — run <code>cd projects/&lt;app&gt; &amp;&amp; php artisan serve</code> for clean URLs.<br>
        Demo login: <code>admin@demo.local</code> / <code>admin123</code> · Stack: Laravel 13, Eloquent, Blade, SQLite
    </p>
</div>
</body>
</html>
