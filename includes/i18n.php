<?php
/**
 * i18n — language detection + translation helpers.
 *
 * Usage:  t('key')   -> translated string (HTML allowed, trusted content)
 *         ta('key')  -> translated array
 *
 * Language is picked from ?lang=xx (persisted to a 1-year cookie),
 * falling back to the cookie, then English.
 * To add a language: create lang/xx.php and add it below.
 */

$AVAILABLE_LANGS = [
    'en' => 'English',
    'hi' => 'हिन्दी',
    'gu' => 'ગુજરાતી',
];

$lang = 'en';
if (isset($_GET['lang'], $AVAILABLE_LANGS[$_GET['lang']])) {
    $lang = $_GET['lang'];
    if (!headers_sent()) {
        setcookie('site_lang', $lang, time() + 31536000, '/');
    }
} elseif (!empty($_COOKIE['site_lang']) && isset($AVAILABLE_LANGS[$_COOKIE['site_lang']])) {
    $lang = $_COOKIE['site_lang'];
}
define('SITE_LANG', $lang);

$I18N    = require __DIR__ . '/../lang/' . $lang . '.php';
$I18N_EN = ($lang === 'en') ? $I18N : require __DIR__ . '/../lang/en.php';

function t(string $key): string {
    global $I18N, $I18N_EN;
    $v = $I18N[$key] ?? $I18N_EN[$key] ?? $key;
    return is_string($v) ? $v : $key;
}

function ta(string $key): array {
    global $I18N, $I18N_EN;
    $v = $I18N[$key] ?? $I18N_EN[$key] ?? [];
    return is_array($v) ? $v : [];
}

/** Current URL with a different lang param (for the switcher). */
function lang_url(string $code): string {
    $q = $_GET;
    $q['lang'] = $code;
    return strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query($q);
}
