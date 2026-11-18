<?php
/**
 * Contact form endpoint — POST only, returns JSON.
 * Uses PHPMailer over SMTP when includes/mail-config.php exists,
 * otherwise falls back to PHP mail().
 */
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Method not allowed.']);
    exit;
}

function respond(bool $ok, string $message, int $code = 200): void {
    http_response_code($code);
    echo json_encode(['ok' => $ok, 'message' => $message]);
    exit;
}

require_once __DIR__ . '/includes/config.php';

// Honeypot — bots fill this, humans never see it
if (!empty($_POST['website'])) {
    respond(true, t('form.ok')); // pretend success
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$budget  = trim($_POST['budget'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $subject === '' || $message === '') {
    respond(false, t('form.err.fields'), 422);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, t('form.err.email'), 422);
}

$cfgFile = __DIR__ . '/includes/mail-config.php';
$mailTo  = SITE_EMAIL;
$mailToName = SITE_NAME;

$bodyText = "New message from your portfolio site\n"
    . "--------------------------------------\n"
    . "Name:    $name\n"
    . "Email:   $email\n"
    . "Budget:  " . ($budget ?: 'not specified') . "\n"
    . "Subject: $subject\n"
    . "--------------------------------------\n\n"
    . $message . "\n";

$bodyHtml = '<h3 style="margin:0 0 12px">New message from nikhilagrawal.tech</h3>'
    . '<table cellpadding="6" style="border-collapse:collapse">'
    . '<tr><td><b>Name</b></td><td>' . htmlspecialchars($name) . '</td></tr>'
    . '<tr><td><b>Email</b></td><td>' . htmlspecialchars($email) . '</td></tr>'
    . '<tr><td><b>Budget</b></td><td>' . htmlspecialchars($budget ?: 'not specified') . '</td></tr>'
    . '<tr><td><b>Subject</b></td><td>' . htmlspecialchars($subject) . '</td></tr>'
    . '</table><p style="white-space:pre-wrap">' . nl2br(htmlspecialchars($message)) . '</p>';

$sent = false;
$error = '';

$phpmailerDir = __DIR__ . '/includes/lib/PHPMailer';
if (file_exists($cfgFile) && file_exists($phpmailerDir . '/PHPMailer.php')) {
    $cfg = require $cfgFile;
    $mailTo     = $cfg['MAIL_TO'] ?? $mailTo;
    $mailToName = $cfg['MAIL_TO_NAME'] ?? $mailToName;

    require_once $phpmailerDir . '/Exception.php';
    require_once $phpmailerDir . '/PHPMailer.php';
    require_once $phpmailerDir . '/SMTP.php';

    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $cfg['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $cfg['SMTP_USER'];
        $mail->Password   = $cfg['SMTP_PASS'];
        $mail->SMTPSecure = $cfg['SMTP_SECURE'] === 'ssl'
            ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS
            : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int)$cfg['SMTP_PORT'];

        $mail->setFrom($cfg['MAIL_FROM'], $cfg['MAIL_FROM_NAME']);
        $mail->addAddress($mailTo, $mailToName);
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Portfolio Contact: ' . $subject;
        $mail->Body    = $bodyHtml;
        $mail->AltBody = $bodyText;

        $sent = $mail->send();
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
} else {
    // Fallback: PHP mail() (works on most shared hosting / Laragon Mail Catcher)
    $headers = "From: noreply@" . SITE_DOMAIN . "\r\n"
        . "Reply-To: $name <$email>\r\n"
        . "Content-Type: text/plain; charset=UTF-8\r\n";
    $sent = @mail($mailTo, 'Portfolio Contact: ' . $subject, $bodyText, $headers);
    if (!$sent) {
        $error = 'mail() not configured on this server. Add SMTP credentials in includes/mail-config.php';
    }
}

if ($sent) {
    respond(true, str_replace('{name}', explode(' ', $name)[0], t('form.sent')));
}

respond(false, t('form.err.fail') . ' ' . $mailTo . ($error ? ' [' . $error . ']' : ''), 500);
