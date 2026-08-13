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

function captcha_question(string $scope): string
{
    if (empty($_SESSION['captcha'][$scope])) {
        $a = random_int(2, 9);
        $b = random_int(1, 9);
        $_SESSION['captcha'][$scope] = ['answer' => $a + $b, 'question' => "$a + $b"];
    }
    return (string) $_SESSION['captcha'][$scope]['question'];
}

function verify_captcha(string $scope, string $answer): bool
{
    $expected = $_SESSION['captcha'][$scope]['answer'] ?? null;
    unset($_SESSION['captcha'][$scope]);
    return $expected !== null && hash_equals((string) $expected, trim($answer));
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

function product_brand_style(string $brand): array
{
    $styles = [
        'kaspersky' => ['mark'=>'K','accent'=>'#20b86a'], 'fortinet' => ['mark'=>'F','accent'=>'#ee3124'],
        'microsoft' => ['mark'=>'⊞','accent'=>'#2589e8'], 'veeam' => ['mark'=>'V','accent'=>'#00b58b'],
        'acronis' => ['mark'=>'△','accent'=>'#4466dd'], 'axcient' => ['mark'=>'∞','accent'=>'#ff6b35'],
        'sage' => ['mark'=>'S','accent'=>'#00a376'], 'sophos' => ['mark'=>'⬢','accent'=>'#168bd2'],
        'bitdefender' => ['mark'=>'B','accent'=>'#d9252a'], 'backblaze' => ['mark'=>'B2','accent'=>'#e84b36'],
        'nakivo' => ['mark'=>'N','accent'=>'#66a52e'], 'distritech' => ['mark'=>'D','accent'=>'#1668e8'],
    ];
    return $styles[mb_strtolower(trim($brand))] ?? ['mark'=>strtoupper(mb_substr($brand, 0, 1)), 'accent'=>'#1668e8'];
}
