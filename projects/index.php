<?php
// Public hub listing all demo applications.
function h($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
$apps = [];
foreach (glob(__DIR__ . '/*/config.php') as $cfg) {
    $c = require $cfg;
    $c['dir'] = basename(dirname($cfg));
    $apps[] = $c;
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
.demo-note{margin-top:2rem;font-size:.8rem;opacity:.5;text-align:center}
.demo-note code{background:rgba(255,255,255,.08);padding:.15rem .45rem;border-radius:6px}
</style>
</head>
<body>
<div class="hub">
    <h1>Demo Applications</h1>
    <p class="sub">Live demos of products built by Nikhil Agrawal · <a href="../portfolio.php" style="color:#a29bfe">← Back to Portfolio</a></p>
    <div class="hub-grid">
        <?php foreach ($apps as $a): ?>
            <a class="hub-card" href="<?= h($a['dir']) ?>/login.php" style="--acc:<?= h($a['accent']) ?>">
                <span class="hub-ico" style="background:<?= h($a['accent']) ?>"><?= $a['icon'] ?></span>
                <span><h3><?= h($a['name']) ?></h3><p><?= count($a['nav']) - 1 ?> modules · PHP + SQLite</p></span>
            </a>
        <?php endforeach; ?>
    </div>
    <p class="demo-note">Demo login for every app — <code>admin@demo.local</code> / <code>admin123</code></p>
</div>
</body>
</html>
