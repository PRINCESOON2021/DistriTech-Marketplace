<?php

declare(strict_types=1);
session_start();
require dirname(__DIR__) . '/app/Database.php';
require dirname(__DIR__) . '/app/ProductRepository.php';
require dirname(__DIR__) . '/app/helpers.php';

$repository = new ProductRepository();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    if (isset($_POST['remove'])) {
        unset($_SESSION['cart'][$id]);
    } else {
        $quantity = max(0, min(99, (int) ($_POST['quantity'] ?? 1)));
        if ($quantity === 0) unset($_SESSION['cart'][$id]); else $_SESSION['cart'][$id] = $quantity;
    }
    header('Location: ' . url('cart.php'));
    exit;
}

$items = [];
$total = 0.0;
$hasQuoteOnly = false;
foreach ($_SESSION['cart'] ?? [] as $id => $quantity) {
    $product = $repository->find((int) $id);
    if ($product === null) continue;
    $lineTotal = $product['sale_price'] === null ? null : (float) $product['sale_price'] * (int) $quantity;
    if ($lineTotal !== null) $total += $lineTotal; else $hasQuoteOnly = true;
    $items[] = ['product' => $product, 'quantity' => (int) $quantity, 'line_total' => $lineTotal];
}
$pageTitle = 'Votre panier';
require __DIR__ . '/partials/header.php';
?>
<section class="section cart-page"><div class="section-heading"><div><span class="eyebrow">VOTRE SÉLECTION</span><h1>Panier</h1></div><a href="<?= e(url('products.php')) ?>">Continuer mes achats →</a></div>
<?php if (isset($_GET['added'])): ?><div class="notice success">Produit ajouté au panier.</div><?php endif; ?>
<?php if ($items === []): ?><div class="empty-state"><h2>Votre panier est vide</h2><p>Découvrez les solutions les plus demandées par nos clients professionnels.</p><a class="button primary" href="<?= e(url('products.php')) ?>">Voir le catalogue</a></div>
<?php else: ?><div class="cart-layout"><div class="cart-items"><?php foreach ($items as $item): $product = $item['product']; ?><article class="cart-item"><div class="mini-visual"><?= e(strtoupper(substr($product['brand'], 0, 2))) ?></div><div class="cart-main"><small><?= e($product['brand']) ?> • <?= e($product['sku']) ?></small><h3><a href="<?= e(url('product.php?id=' . $product['id'])) ?>"><?= e($product['name']) ?></a></h3><span><?= e($product['version']) ?> — <?= e($product['users_label']) ?></span></div><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int) $product['id'] ?>"><label>Qté<input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="0" max="99" onchange="this.form.submit()"></label><button class="text-button" type="submit" name="remove">Supprimer</button></form><strong><?= e(money($item['line_total'])) ?></strong></article><?php endforeach; ?></div>
<aside class="cart-summary"><h2>Récapitulatif</h2><div><span>Sous-total indicatif</span><strong><?= e(money($total)) ?></strong></div><?php if ($hasQuoteOnly): ?><p>Certains produits nécessitent une configuration et seront chiffrés dans le devis.</p><?php endif; ?><a class="button primary full" href="<?= e(url('quote.php?cart=1')) ?>">Transformer en devis</a><small>Un conseiller valide les licences, quantités et services avant commande.</small></aside></div><?php endif; ?></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
