<?php
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 0,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => true, // Set to false if not using HTTPS
    'httponly' => true
]);

session_start();

// Regenerate session ID periodically (every 30 minutes)
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > 1800) { // 30 minutes
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}
