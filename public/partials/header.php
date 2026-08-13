<?php $pageTitle = $pageTitle ?? 'Solutions IT, cybersécurité et cloud'; ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DISTRITECH accompagne les entreprises avec des solutions IT, cybersécurité, cloud, backup et Sage.">
    <title><?= e($pageTitle) ?> | DISTRITECH</title>
    <link rel="stylesheet" href="<?= e(url('assets/css/app.css?v=20260813-10')) ?>">
    <link rel="stylesheet" href="<?= e(url('assets/css/premium.css?v=20260813-10')) ?>">
</head>
<body>
<div class="topbar">Solutions professionnelles pour entreprises au Maroc <a href="<?= e(url('quote.php')) ?>">Demander un audit</a></div>
<header class="site-header">
    <a class="brand brand-logo" href="<?= e(url('index.php')) ?>" aria-label="DISTRITECH — Accueil"><img src="<?= e(url('assets/images/distritech-logo-rouge.webp')) ?>" alt="DISTRITECH"></a>
    <button class="menu-toggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false">☰</button>
    <nav class="main-nav" aria-label="Navigation principale">
        <a href="<?= e(url('index.php')) ?>">Accueil</a>
        <div class="nav-group">
            <button type="button">Produits ▾</button>
            <div class="mega-menu">
                <a href="<?= e(url('products.php?category=cybersecurite')) ?>"><b>Cybersécurité</b><span>Endpoint, EDR et protection</span></a>
                <a href="<?= e(url('products.php?category=firewall')) ?>"><b>Firewall</b><span>FortiGate et sécurité réseau</span></a>
                <a href="<?= e(url('products.php?category=microsoft')) ?>"><b>Microsoft</b><span>Microsoft 365, Server et CAL</span></a>
                <a href="<?= e(url('products.php?category=backup')) ?>"><b>Backup</b><span>Veeam, Acronis et Axcient</span></a>
                <a href="<?= e(url('products.php?category=sage')) ?>"><b>Sage</b><span>Comptabilité et gestion</span></a>
                <a href="<?= e(url('products.php')) ?>"><b>Tout le catalogue</b><span>Voir toutes les solutions</span></a>
            </div>
        </div>
        <a href="<?= e(url('index.php#solutions')) ?>">Solutions</a>
        <a href="<?= e(url('index.php#services')) ?>">Services</a>
        <a class="nav-quote" href="<?= e(url('quote.php')) ?>">Devis</a>
        <a class="cart-link" href="<?= e(url('cart.php')) ?>">Panier <span><?= cart_count() ?></span></a>
    </nav>
</header>
<main>
