<?php

declare(strict_types=1);
session_start();
require dirname(__DIR__) . '/app/Database.php';
require dirname(__DIR__) . '/app/ProductRepository.php';
require dirname(__DIR__) . '/app/helpers.php';

$repository = new ProductRepository();
$search = trim((string) ($_GET['q'] ?? ''));
$category = trim((string) ($_GET['category'] ?? ''));
$products = $repository->all($search, $category);
$categories = $repository->categories();
$pageTitle = 'Solutions IT, cybersécurité et cloud';
require __DIR__ . '/partials/header.php';
?>
<section class="hero">
    <div class="hero-copy">
        <span class="eyebrow">INTÉGRATEUR IT B2B • MAROC</span>
        <h1>Sécurisez, connectez et développez votre entreprise.</h1>
        <p>Licences, infrastructures, cybersécurité, cloud et services managés réunis avec un accompagnement de bout en bout.</p>
        <div class="actions"><a class="button primary" href="#catalogue">Voir les produits</a><a class="button ghost" href="<?= e(url('quote.php')) ?>">Demander un audit</a></div>
        <div class="trust"><span>Conseil expert</span><span>Déploiement professionnel</span><span>Support local</span></div>
    </div>
    <div class="hero-art" aria-hidden="true">
        <img src="<?= e(url('assets/images/hero-cybersecurity.webp')) ?>" alt="" fetchpriority="high">
        <div class="floating-card card-security"><span class="pulse-dot"></span><div><b>Protection active</b><small>Infrastructure surveillée</small></div></div>
        <div class="floating-card card-backup"><span>↻</span><div><b>Backup vérifié</b><small>Copie hors site sécurisée</small></div></div>
    </div>
</section>

<section class="brand-marquee" aria-label="Éditeurs et technologies"><div class="marquee-track"><span>MICROSOFT</span><span>FORTINET</span><span>KASPERSKY</span><span>VEEAM</span><span>ACRONIS</span><span>SAGE</span><span>AXCIENT</span><span>BACKBLAZE</span><span aria-hidden="true">MICROSOFT</span><span aria-hidden="true">FORTINET</span><span aria-hidden="true">KASPERSKY</span><span aria-hidden="true">VEEAM</span></div></section>

<section class="proof-strip reveal"><div><strong>360°</strong><span>Protection globale</span></div><div><strong>9</strong><span>Catégories IT</span></div><div><strong>24/7</strong><span>Monitoring disponible</span></div><div><strong>Maroc</strong><span>Accompagnement local</span></div></section>

<section class="category-strip" aria-label="Catégories">
    <?php foreach ($categories as $item): ?>
        <a href="?category=<?= e($item['slug']) ?>#catalogue"><?= e($item['name']) ?></a>
    <?php endforeach; ?>
</section>

<section class="section reveal" id="catalogue">
    <div class="section-heading"><div><span class="eyebrow">CATALOGUE DISTRITECH</span><h2>Solutions les plus demandées</h2></div><p>Choisissez un produit ou demandez une configuration sur mesure.</p></div>
    <form class="catalog-filters" method="get" action="<?= e(url('index.php')) ?>#catalogue">
        <label><span>Rechercher</span><input type="search" name="q" value="<?= e($search) ?>" placeholder="Produit, marque ou SKU"></label>
        <label><span>Catégorie</span><select name="category"><option value="">Toutes les catégories</option><?php foreach ($categories as $item): ?><option value="<?= e($item['slug']) ?>" <?= $category === $item['slug'] ? 'selected' : '' ?>><?= e($item['name']) ?></option><?php endforeach; ?></select></label>
        <button class="button primary" type="submit">Filtrer</button>
    </form>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <article class="product-card">
                <div class="product-top"><span class="category-pill"><?= e($product['category_name']) ?></span><?php if ((int) $product['featured'] === 1): ?><span class="featured">Populaire</span><?php endif; ?></div>
                <div class="product-card-visual"><span><?= e(strtoupper(substr($product['brand'], 0, 2))) ?></span><i></i></div>
                <div class="product-brand"><?= e($product['brand']) ?></div>
                <h3><a href="<?= e(url('product.php?id=' . $product['id'])) ?>"><?= e($product['name']) ?></a></h3>
                <p><?= e($product['short_description']) ?></p>
                <dl><div><dt>Version</dt><dd><?= e($product['version']) ?></dd></div><div><dt>Licence</dt><dd><?= e($product['license_type']) ?></dd></div></dl>
                <div class="product-footer"><div><small><?= e($product['unit']) ?></small><strong><?= e(money($product['sale_price'] === null ? null : (float) $product['sale_price'])) ?></strong></div><a class="button small" href="<?= e(url('product.php?id=' . $product['id'])) ?>">Voir</a></div>
            </article>
        <?php endforeach; ?>
        <?php if ($products === []): ?><div class="empty-state"><h3>Aucun produit trouvé</h3><p>Modifiez vos filtres ou demandez une solution personnalisée.</p></div><?php endif; ?>
    </div>
</section>

<section class="dark-section reveal" id="solutions"><span class="eyebrow">SOLUTIONS MÉTIERS</span><h2>Une réponse complète à chaque enjeu.</h2><div class="solution-grid"><article><span class="solution-icon">◇</span><b>Protection ransomware</b><p>EDR, firewall, copie immuable et plan de restauration.</p><a href="<?= e(url('quote.php')) ?>">Découvrir →</a></article><article><span class="solution-icon">⌁</span><b>Interconnexion multi-sites</b><p>VPN, SD-WAN et accès cloud sécurisés.</p><a href="<?= e(url('quote.php')) ?>">Découvrir →</a></article><article><span class="solution-icon">↻</span><b>Continuité d’activité</b><p>Backup, PRA et reprise rapide des workloads.</p><a href="<?= e(url('quote.php')) ?>">Découvrir →</a></article></div></section>

<section class="section reveal" id="services"><div class="section-heading"><div><span class="eyebrow">SERVICES DISTRITECH</span><h2>De l’audit au support continu.</h2></div><p>Une équipe unique pilote vos solutions, du cadrage initial au maintien en conditions opérationnelles.</p></div><div class="service-grid"><article><span>01</span><h3>Audit & conseil</h3><p>Analyse de l’existant et feuille de route adaptée.</p></article><article><span>02</span><h3>Installation</h3><p>Paramétrage, migration et mise en production.</p></article><article><span>03</span><h3>MSP & maintenance</h3><p>Monitoring, support, sécurité et rapports réguliers.</p></article></div></section>

<section class="cta-band reveal"><div><span class="eyebrow">PARLONS DE VOTRE PROJET</span><h2>Recevez une proposition adaptée à votre entreprise.</h2></div><a class="button light" href="<?= e(url('quote.php')) ?>">Demander un devis</a></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
