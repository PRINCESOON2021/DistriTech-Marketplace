<?php

declare(strict_types=1);
require dirname(__DIR__) . '/app/security.php';
secure_session_start();
require dirname(__DIR__) . '/app/Database.php';
require dirname(__DIR__) . '/app/ProductRepository.php';
require dirname(__DIR__) . '/app/helpers.php';

$repository = new ProductRepository();
$product = $repository->find((int) ($_GET['id'] ?? 0));
if ($product === null) {
    http_response_code(404);
    $pageTitle = 'Produit introuvable';
    require __DIR__ . '/partials/header.php';
    echo '<section class="section empty-state"><h1>Produit introuvable</h1><a class="button primary" href="' . e(url('products.php')) . '">Retour au catalogue</a></section>';
    require __DIR__ . '/partials/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $quantity = max(1, min(99, (int) ($_POST['quantity'] ?? 1)));
    $_SESSION['cart'][(int) $product['id']] = ($_SESSION['cart'][(int) $product['id']] ?? 0) + $quantity;
    header('Location: ' . url('cart.php?added=1'));
    exit;
}

$pageTitle = $product['name'];
require __DIR__ . '/partials/header.php';
?>
<section class="breadcrumb"><a href="<?= e(url('index.php')) ?>">Accueil</a><span>/</span><a href="<?= e(url('products.php?category=' . $product['category_slug'])) ?>"><?= e($product['category_name']) ?></a><span>/</span><?= e($product['name']) ?></section>
<section class="product-detail">
    <div class="product-visual product-photo"><img src="<?= e(url(product_image($product['sku']))) ?>" alt="<?= e($product['name']) ?>"><small><?= e($product['brand']) ?></small></div>
    <div class="product-info"><span class="category-pill"><?= e($product['category_name']) ?></span><h1><?= e($product['name']) ?></h1><p class="lead"><?= e($product['short_description']) ?></p><div class="price-block"><small>Prix indicatif</small><strong><?= e(money($product['sale_price'] === null ? null : (float) $product['sale_price'])) ?></strong><span><?= e($product['unit']) ?></span></div>
        <dl class="specs"><div><dt>SKU</dt><dd><?= e($product['sku']) ?></dd></div><div><dt>Version</dt><dd><?= e($product['version']) ?></dd></div><div><dt>Utilisateurs</dt><dd><?= e($product['users_label']) ?></dd></div><div><dt>Type de licence</dt><dd><?= e($product['license_type']) ?></dd></div></dl>
        <form class="buy-form" method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Quantité<input type="number" name="quantity" value="1" min="1" max="99"></label><button class="button primary" type="submit">Ajouter au panier</button><a class="button ghost-dark" href="<?= e(url('quote.php?product=' . $product['id'])) ?>">Demander un devis</a></form>
        <p class="fine-print">Le prix final dépend de la version, du nombre d’utilisateurs, de la durée et des services d’installation.</p>
    </div>
</section>
<section class="section product-benefits"><h2>Services inclus sur demande</h2><div class="service-grid"><article><h3>Conseil & dimensionnement</h3><p>Validation de la licence et du périmètre adaptés.</p></article><article><h3>Installation & migration</h3><p>Déploiement sécurisé avec reprise de l’existant.</p></article><article><h3>Support & maintenance</h3><p>Assistance locale et contrat de suivi personnalisé.</p></article></div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
