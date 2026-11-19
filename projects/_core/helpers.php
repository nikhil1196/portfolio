<?php
/** Common helpers: escaping, request, flash, CSRF, query shorthands. */

function h($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function getv(string $k, $d = '') { return $_GET[$k] ?? $d; }
function postv(string $k, $d = '') { return $_POST[$k] ?? $d; }
function is_post(): bool { return $_SERVER['REQUEST_METHOD'] === 'POST'; }
function redirect(string $to): void { header('Location: ' . $to); exit; }

function flash(string $msg, string $type = 'ok'): void { $_SESSION['flash'][] = [$msg, $type]; }
function flashes(): array { $f = $_SESSION['flash'] ?? []; unset($_SESSION['flash']); return $f; }

function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}
function csrf_field(): string { return '<input type="hidden" name="_csrf" value="' . csrf_token() . '">'; }
function csrf_check(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['_csrf'] ?? '')) {
        http_response_code(419); exit('Invalid CSRF token.');
    }
}

// --- DB shorthands (all prepared) ---
function q(array $app, string $sql, array $params = []): PDOStatement {
    $st = $app['db']->prepare($sql); $st->execute($params); return $st;
}
function qa(array $app, string $sql, array $p = []): array { return q($app, $sql, $p)->fetchAll(); }
function q1(array $app, string $sql, array $p = []): array|false { return q($app, $sql, $p)->fetch(); }
function qv(array $app, string $sql, array $p = []) {
    $r = q1($app, $sql, $p); return $r ? array_values($r)[0] : null;
}
function table_count(array $app, string $table, string $where = '1=1', array $p = []): int {
    return (int) qv($app, "SELECT COUNT(*) FROM $table WHERE $where", $p);
}

// --- Formatting ---
function money($n, string $sym = '₹'): string { return $sym . number_format((float)$n, 0); }
function dt($d, string $f = 'd M Y'): string { return $d ? date($f, strtotime($d)) : '—'; }
function status_badge($s): string {
    $cls = preg_replace('/[^a-z]/', '', strtolower((string)$s));
    return '<span class="badge b-' . $cls . '">' . h($s) . '</span>';
}
