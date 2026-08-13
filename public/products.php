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
<section class="catalog-hero">
    <div><span class="eyebrow">CATALOGUE DISTRITECH</span><h1>La technologie qui fait avancer votre entreprise.</h1><p>Cybersécurité, cloud, licences, réseau et continuité d’activité réunis dans une sélection professionnelle.</p></div>
    <div class="catalog-orbit" aria-hidden="true"><span>IT</span><i>SECURE</i><b>CLOUD</b></div>
</section>
<section class="section catalog-page" id="catalogue">
    <div class="section-heading catalog-heading"><div><span class="eyebrow">EXPLORER LES SOLUTIONS</span><h2>Tous nos produits et licences</h2></div><p><?= count($products) ?> solution<?= count($products) > 1 ? 's' : '' ?> disponible<?= count($products) > 1 ? 's' : '' ?></p></div>
    <div class="category-strip catalog-categories" aria-label="Catégories">
        <a href="<?= e(url('products.php')) ?>">Tous</a>
        <?php foreach ($categories as $item): ?><a href="<?= e(url('products.php?category=' . $item['slug'])) ?>"><?= e($item['name']) ?></a><?php endforeach; ?>
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
