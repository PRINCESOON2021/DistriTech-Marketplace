<?php

declare(strict_types=1);

function send_security_headers(): void
{
    if (headers_sent()) return;

    header("Content-Security-Policy: default-src 'self'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'; object-src 'none'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self'; upgrade-insecure-requests");
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(), usb=()');
    header('Cross-Origin-Opener-Policy: same-origin');
    header('Cross-Origin-Resource-Policy: same-origin');
    header('X-Permitted-Cross-Domain-Policies: none');

    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    if ($https) header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}

function secure_session_start(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) return;

    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_samesite', 'Lax');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_name('DISTRITECHSESSID');
    session_start();
    send_security_headers();
}

function login_rate_limited(): bool
{
    $window = 15 * 60;
    $attempts = array_values(array_filter(
        $_SESSION['login_attempts'] ?? [],
        static fn ($timestamp): bool => is_int($timestamp) && $timestamp > time() - $window
    ));
    $_SESSION['login_attempts'] = $attempts;
    return count($attempts) >= 5;
}

function register_login_failure(): void
{
    $_SESSION['login_attempts'][] = time();
}

function clear_login_failures(): void
{
    unset($_SESSION['login_attempts']);
}
