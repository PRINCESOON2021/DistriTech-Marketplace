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
$pageTitle = 'Catalogue produits';
require __DIR__ . '/partials/header.php';
?>
<div class="breadcrumb"><a href="<?= e(url('index.php')) ?>">Accueil</a><span>›</span><span>Produits</span></div>
<section class="section catalog-page" id="catalogue">
    <div class="section-heading"><div><span class="eyebrow">CATALOGUE DISTRITECH</span><h1>Tous nos produits et licences</h1></div><p>Recherchez une solution par marque, référence ou catégorie.</p></div>
    <div class="category-strip catalog-categories" aria-label="Catégories">
        <a href="<?= e(url('products.php')) ?>">Tous</a>
        <?php foreach ($categories as $item): ?><a href="<?= e(url('products.php?category=' . $item['slug'])) ?>"><?= e($item['name']) ?></a><?php endforeach; ?>
    </div>
    <form class="catalog-filters" method="get" action="<?= e(url('products.php')) ?>">
        <label><span>Rechercher</span><input type="search" name="q" value="<?= e($search) ?>" placeholder="Produit, marque ou SKU"></label>
        <label><span>Catégorie</span><select name="category"><option value="">Toutes les catégories</option><?php foreach ($categories as $item): ?><option value="<?= e($item['slug']) ?>" <?= $category === $item['slug'] ? 'selected' : '' ?>><?= e($item['name']) ?></option><?php endforeach; ?></select></label>
        <button class="button primary" type="submit">Filtrer</button>
    </form>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <article class="product-card">
                <div class="product-top"><span class="category-pill"><?= e($product['category_name']) ?></span><?php if ((int) $product['featured'] === 1): ?><span class="featured">Populaire</span><?php endif; ?></div>
                <div class="product-card-visual"><img src="<?= e(url(product_image($product['sku']))) ?>" alt="<?= e($product['name']) ?>" loading="lazy"></div>
                <div class="product-brand"><?= e($product['brand']) ?></div><h3><a href="<?= e(url('product.php?id=' . $product['id'])) ?>"><?= e($product['name']) ?></a></h3><p><?= e($product['short_description']) ?></p>
                <dl><div><dt>Version</dt><dd><?= e($product['version']) ?></dd></div><div><dt>Licence</dt><dd><?= e($product['license_type']) ?></dd></div></dl>
                <div class="product-footer"><div><small><?= e($product['unit']) ?></small><strong><?= e(money($product['sale_price'] === null ? null : (float) $product['sale_price'])) ?></strong></div><a class="button small" href="<?= e(url('product.php?id=' . $product['id'])) ?>">Voir</a></div>
            </article>
        <?php endforeach; ?>
        <?php if ($products === []): ?><div class="empty-state"><h3>Aucun produit trouvé</h3><p>Modifiez vos filtres ou demandez une solution personnalisée.</p></div><?php endif; ?>
    </div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
