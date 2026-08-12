<?php

declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    $config = require dirname(__DIR__) . '/config/app.php';
    if ($config['base_url'] !== '') {
        return $config['base_url'] . '/' . ltrim($path, '/');
    }
    $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

function money(?float $amount): string
{
    return $amount === null ? 'Sur devis' : number_format($amount, 0, ',', ' ') . ' DH HT';
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(24));
    }
    return $_SESSION['csrf'];
}

function verify_csrf(): void
{
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419);
        exit('Session expirée. Rechargez la page.');
    }
}

function cart_count(): int
{
    return array_sum(array_map('intval', $_SESSION['cart'] ?? []));
}

function product_image(string $sku): string
{
    $prefixes = [
        'KAS-' => 'kaspersky.webp', 'FTG-' => 'fortigate.webp',
        'M365-' => 'microsoft.webp', 'MS-' => 'microsoft.webp',
        'WIN11-' => 'microsoft.webp', 'WS-' => 'windows-server.webp', 'RDS-' => 'windows-server.webp',
        'VEEAM-' => 'veeam.webp', 'ACR-' => 'acronis.webp',
        'AXC-' => 'axcient.webp', 'SAGE' => 'sage.webp',
        'SOP-' => 'sophos.webp', 'BIT-' => 'bitdefender.webp',
        'NAKIVO-' => 'veeam.webp',
    ];
    foreach ($prefixes as $prefix => $file) {
        if (str_starts_with(strtoupper($sku), $prefix)) return 'assets/images/products/' . $file;
    }
    return 'assets/images/hero-datacenter-real.webp';
}
