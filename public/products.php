<?php

declare(strict_types=1);
session_start();
require dirname(__DIR__) . '/app/Database.php';
require dirname(__DIR__) . '/app/ProductRepository.php';
require dirname(__DIR__) . '/app/helpers.php';

$repository = new ProductRepository();
$search = trim((string) ($_GET['q'] ?? ''));
$category = trim((string) ($_GET['category'] ?? ''));
$sort = trim((string) ($_GET['sort'] ?? 'featured'));
$products = $repository->all($search, $category);
$categories = $repository->categories();
$visibleBrands = [];
foreach ($products as $visibleProduct) {
    $visibleBrands[$visibleProduct['brand']] = product_brand_style($visibleProduct['brand']);
}
$visibleBrands = array_slice($visibleBrands, 0, 5, true);
$selectedCategoryName = 'Solutions IT';
foreach ($categories as $categoryItem) {
    if ($categoryItem['slug'] === $category) {
        $selectedCategoryName = $categoryItem['name'];
        break;
    }
}
$categoryPresentations = [
    '' => ['label'=>'TOUT LE CATALOGUE','title'=>'Toutes les solutions IT pour votre entreprise.','description'=>'Découvrez notre sélection complète : cybersécurité, firewall, Microsoft, sauvegarde, gestion et services professionnels.','mark'=>'DT','accent'=>'#27c8ee','nodes'=>['CYBERSÉCURITÉ','CLOUD','BACKUP']],
    'cybersecurite' => ['label'=>'CYBERSÉCURITÉ','title'=>'Protégez vos utilisateurs, postes et données.','description'=>'Antivirus, EDR et protection avancée contre les ransomwares, attaques ciblées et menaces numériques.','mark'=>'◆','accent'=>'#20b86a','nodes'=>['UTILISATEURS','EDR / XDR','MENACES']],
    'firewall' => ['label'=>'FIREWALL & RÉSEAU','title'=>'Sécurisez chaque connexion de votre entreprise.','description'=>'Pare-feu nouvelle génération, filtrage, VPN et protection des échanges entre Internet, siège et sites distants.','mark'=>'⬡','accent'=>'#ee3124','nodes'=>['INTERNET','FIREWALL','LAN / VPN']],
    'microsoft' => ['label'=>'MICROSOFT','title'=>'Modernisez le travail et l’infrastructure.','description'=>'Microsoft 365, Windows, Server, CAL et cloud pour améliorer la collaboration, la sécurité et la productivité.','mark'=>'⊞','accent'=>'#2589e8','nodes'=>['ÉQUIPES','MICROSOFT 365','CLOUD']],
    'backup' => ['label'=>'BACKUP & PRA','title'=>'Sauvegardez maintenant, restaurez rapidement.','description'=>'Protection des workloads, copies hors site, réplication et reprise d’activité après incident ou ransomware.','mark'=>'↻','accent'=>'#00b58b','nodes'=>['DONNÉES','BACKUP','RESTORE']],
    'sage' => ['label'=>'GESTION SAGE','title'=>'Pilotez votre activité avec des données fiables.','description'=>'Comptabilité, gestion commerciale, ventes, stocks, facturation et trésorerie réunis dans un environnement professionnel.','mark'=>'S','accent'=>'#00a376','nodes'=>['VENTES','SAGE 100','FINANCE']],
];
$categoryPresentation = $categoryPresentations[$category] ?? [
    'label'=>mb_strtoupper($selectedCategoryName),
    'title'=>'Des solutions professionnelles adaptées à votre activité.',
    'description'=>'Découvrez les produits, licences et services sélectionnés par DISTRITECH pour cette catégorie.',
    'mark'=>'IT','accent'=>'#1668e8','nodes'=>['BESOIN','SOLUTION','SUPPORT'],
];
$sortOptions = ['featured', 'name_asc', 'brand_asc', 'price_asc', 'price_desc'];
if (!in_array($sort, $sortOptions, true)) {
    $sort = 'featured';
}
if ($sort !== 'featured') {
    usort($products, static function (array $a, array $b) use ($sort): int {
        if ($sort === 'name_asc') return strcasecmp((string) $a['name'], (string) $b['name']);
        if ($sort === 'brand_asc') return strcasecmp((string) $a['brand'], (string) $b['brand']);
        if ($a['sale_price'] === null) return 1;
        if ($b['sale_price'] === null) return -1;
        $priceA = (float) $a['sale_price'];
        $priceB = (float) $b['sale_price'];
        return $sort === 'price_desc' ? $priceB <=> $priceA : $priceA <=> $priceB;
    });
}
$pageTitle = 'Catalogue produits';
require __DIR__ . '/partials/header.php';
?>
<div class="breadcrumb"><a href="<?= e(url('index.php')) ?>">Accueil</a><span>›</span><span>Produits</span></div>
<section class="catalog-hero category-hero" style="--category-accent:<?= e($categoryPresentation['accent']) ?>">
    <div><span class="eyebrow"><?= e($categoryPresentation['label']) ?> • DISTRITECH</span><h1><?= e($categoryPresentation['title']) ?></h1><p><?= e($categoryPresentation['description']) ?></p><div class="category-benefits"><span>Conseil expert</span><span>Déploiement</span><span>Support local</span></div></div>
    <div class="catalog-brand-schema" aria-label="Présentation de la catégorie <?= e($selectedCategoryName) ?>">
        <div class="category-pro-logo"><i><?= e($categoryPresentation['mark']) ?></i><div><b><?= e($categoryPresentation['label']) ?></b><small>Solutions professionnelles</small></div></div>
        <div class="catalog-schema-core"><span><?= e($categoryPresentation['mark']) ?></span><b><?= e($selectedCategoryName) ?></b><small>Architecture DISTRITECH</small></div>
        <div class="category-schema-flow"><?php foreach ($categoryPresentation['nodes'] as $nodeIndex => $node): ?><div><i><?= $nodeIndex === 0 ? '◉' : ($nodeIndex === 1 ? $categoryPresentation['mark'] : '✓') ?></i><b><?= e($node) ?></b></div><?php if ($nodeIndex < 2): ?><span><em></em></span><?php endif; ?><?php endforeach; ?></div>
        <div class="catalog-schema-ring">
            <?php foreach ($visibleBrands as $brandName => $brandStyle): ?>
                <div class="catalog-brand-logo" style="--logo-accent:<?= e($brandStyle['accent']) ?>"><i><?= e($brandStyle['mark']) ?></i><b><?= e($brandName) ?></b></div>
            <?php endforeach; ?>
            <?php if ($visibleBrands === []): ?><div class="catalog-brand-logo" style="--logo-accent:#27c8ee"><i>IT</i><b>DISTRITECH</b></div><?php endif; ?>
        </div>
        <div class="catalog-schema-caption"><span></span>Solutions certifiées • Déploiement professionnel</div>
    </div>
</section>
<section class="section catalog-page" id="catalogue">
    <div class="section-heading catalog-heading"><div><span class="eyebrow">EXPLORER LES SOLUTIONS</span><h2>Tous nos produits et licences</h2></div><p><?= count($products) ?> solution<?= count($products) > 1 ? 's' : '' ?> disponible<?= count($products) > 1 ? 's' : '' ?></p></div>
    <div class="category-strip catalog-categories" aria-label="Catégories">
        <a class="<?= $category === '' ? 'active' : '' ?>" href="<?= e(url('products.php')) ?>">Tous</a>
        <?php foreach ($categories as $item): ?><a class="<?= $category === $item['slug'] ? 'active' : '' ?>" href="<?= e(url('products.php?category=' . $item['slug'])) ?>"><?= e($item['name']) ?></a><?php endforeach; ?>
    </div>
    <form class="catalog-filters catalog-toolbar" method="get" action="<?= e(url('products.php')) ?>">
        <label><span>Rechercher</span><input type="search" name="q" value="<?= e($search) ?>" placeholder="Produit, marque ou SKU"></label>
        <label><span>Catégorie</span><select name="category"><option value="">Toutes les catégories</option><?php foreach ($categories as $item): ?><option value="<?= e($item['slug']) ?>" <?= $category === $item['slug'] ? 'selected' : '' ?>><?= e($item['name']) ?></option><?php endforeach; ?></select></label>
        <label><span>Trier par</span><select name="sort"><option value="featured" <?= $sort === 'featured' ? 'selected' : '' ?>>Produits populaires</option><option value="name_asc" <?= $sort === 'name_asc' ? 'selected' : '' ?>>Nom A–Z</option><option value="brand_asc" <?= $sort === 'brand_asc' ? 'selected' : '' ?>>Marque A–Z</option><option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Prix croissant</option><option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Prix décroissant</option></select></label>
        <button class="button primary" type="submit">Filtrer</button>
    </form>
    <div class="catalog-viewbar"><span>Mode d’affichage</span><div role="group" aria-label="Mode d’affichage"><button class="view-toggle active" type="button" data-view="grid" aria-pressed="true" title="Affichage en grille">▦ <span>Grille</span></button><button class="view-toggle" type="button" data-view="list" aria-pressed="false" title="Affichage en liste">☷ <span>Liste</span></button><button class="view-toggle" type="button" data-view="slide" aria-pressed="false" title="Une référence par slide">▣ <span>Slide</span></button></div></div>
    <?php if ($products !== []): ?>
        <div class="product-slider-controls" aria-label="Navigation entre les références">
            <button type="button" class="slider-arrow slider-prev" aria-label="Référence précédente">←</button>
            <div><strong class="slider-current">1</strong><span>/ <?= count($products) ?></span><small>Une slide par référence produit</small></div>
            <button type="button" class="slider-arrow slider-next" aria-label="Référence suivante">→</button>
        </div>
    <?php endif; ?>
    <div class="product-grid">
        <?php foreach ($products as $index => $product): $brandStyle = product_brand_style($product['brand']); ?>
            <article class="product-card<?= $index === 0 ? ' slide-active' : '' ?>" style="--product-accent:<?= e($brandStyle['accent']) ?>" data-slide-index="<?= $index ?>" data-sku="<?= e($product['sku']) ?>">
                <div class="product-top"><span class="category-pill"><?= e($product['category_name']) ?></span><?php if ((int) $product['featured'] === 1): ?><span class="featured">Populaire</span><?php endif; ?></div>
                <div class="product-card-visual professional-product-visual">
                    <div class="product-logo" aria-label="Logo <?= e($product['brand']) ?>"><i><?= e($brandStyle['mark']) ?></i><b><?= e($product['brand']) ?></b></div>
                    <div class="product-descriptive-image"><img src="<?= e(url(product_image($product['sku']))) ?>" alt="Visuel professionnel de <?= e($product['name']) ?>" loading="lazy"></div>
                    <small><?= e($product['sku']) ?></small>
                </div>
                <div class="product-brand"><?= e($product['brand']) ?></div><h3><a href="<?= e(url('product.php?id=' . $product['id'])) ?>"><?= e($product['name']) ?></a></h3><p><?= e($product['short_description']) ?></p>
                <dl><div><dt>Version</dt><dd><?= e($product['version']) ?></dd></div><div><dt>Licence</dt><dd><?= e($product['license_type']) ?></dd></div></dl>
                <div class="product-footer"><div><small><?= e($product['unit']) ?></small><strong><?= e(money($product['sale_price'] === null ? null : (float) $product['sale_price'])) ?></strong></div><a class="button small" href="<?= e(url('product.php?id=' . $product['id'])) ?>">Voir</a></div>
            </article>
        <?php endforeach; ?>
        <?php if ($products === []): ?><div class="empty-state"><h3>Aucun produit trouvé</h3><p>Modifiez vos filtres ou demandez une solution personnalisée.</p></div><?php endif; ?>
    </div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
