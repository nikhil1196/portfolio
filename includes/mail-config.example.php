<?php
/**
 * SMTP settings for the contact form.
 *
 * 1. Copy this file to "mail-config.php" (same folder)
 * 2. Fill in your real SMTP credentials
 *
 * For Gmail:
 *   - Enable 2-Step Verification on your Google account
 *   - Create an App Password at https://myaccount.google.com/apppasswords
 *   - Use the 16-char app password as MAIL_PASS (NOT your normal password)
 */
return [
    'SMTP_HOST'  => 'smtp.gmail.com',
    'SMTP_PORT'  => 587,
    'SMTP_SECURE'=> 'tls',              // 'tls' (587) or 'ssl' (465)
    'SMTP_USER'  => 'youremail@gmail.com',
    'SMTP_PASS'  => 'your-app-password',

    // Where contact form messages are delivered
    'MAIL_TO'      => 'bansalnikhil777@gmail.com',
    'MAIL_TO_NAME' => 'Nikhil Agrawal',

    // "From" shown on the email you receive
    'MAIL_FROM'      => 'portfolio@nikhilagrawal.tech',
    'MAIL_FROM_NAME' => 'Portfolio Contact Form',
];
