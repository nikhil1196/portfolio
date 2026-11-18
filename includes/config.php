<?php
/**
 * Site-wide configuration & content data.
 * Edit values here to update the whole site.
 * All user-facing text lives in lang/*.php (see i18n.php).
 */

define('SITE_NAME', 'Nikhil Agrawal');
define('SITE_TAGLINE', 'Senior Backend Engineer | Laravel & PHP Specialist | SaaS Platform Developer');
define('SITE_DOMAIN', 'nikhilagrawal.tech');
define('SITE_URL', 'https://nikhilagrawal.tech');
define('SITE_EMAIL', 'bansalnikhil777@gmail.com');
define('SITE_PHONE', '+91-8866398049');
define('SITE_PHONE_LINK', '+918866398049');
define('SITE_LOCATION', 'Vadodara, Gujarat, India');

// Social links — update URLs when ready
$SOCIALS = [
    'github'   => 'https://github.com/',
    'linkedin' => 'https://linkedin.com/in/',
    'twitter'  => 'https://twitter.com/',
    'stackoverflow' => 'https://stackoverflow.com/users/',
];

// Nav items: translation key => file
$NAV_ITEMS = [
    'nav.home'      => 'index.php',
    'nav.about'     => 'about.php',
    'nav.services'  => 'services.php',
    'nav.portfolio' => 'portfolio.php',
    'nav.blog'      => 'blog.php',
    'nav.contact'   => 'contact.php',
];

require_once __DIR__ . '/i18n.php';

function is_active(string $file, string $current): string {
    return $file === $current ? 'active' : '';
}

function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
