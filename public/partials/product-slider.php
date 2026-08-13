<?php

require_once dirname(__DIR__, 2) . '/app/Database.php';
require_once dirname(__DIR__, 2) . '/app/ProductRepository.php';

$globalSliderProducts = (new ProductRepository())->all();
?>
<?php if ($globalSliderProducts !== []): ?>
<section class="global-product-slider" aria-label="Références produits" aria-roledescription="carrousel">
    <div class="global-slider-track">
        <?php foreach ($globalSliderProducts as $sliderIndex => $sliderProduct): ?>
            <article class="global-product-slide<?= $sliderIndex === 0 ? ' active' : '' ?>" data-global-slide="<?= $sliderIndex ?>" aria-hidden="<?= $sliderIndex === 0 ? 'false' : 'true' ?>">
                <div class="global-slide-image"><img src="<?= e(url(product_image($sliderProduct['sku']))) ?>" alt="<?= e($sliderProduct['name']) ?>" <?= $sliderIndex === 0 ? '' : 'loading="lazy"' ?>></div>
                <div class="global-slide-copy"><small><?= e($sliderProduct['brand']) ?> • <?= e($sliderProduct['sku']) ?></small><strong><?= e($sliderProduct['name']) ?></strong><span><?= e($sliderProduct['short_description']) ?></span></div>
                <div class="global-slide-action"><b><?= e(money($sliderProduct['sale_price'] === null ? null : (float) $sliderProduct['sale_price'])) ?></b><a href="<?= e(url('product.php?id=' . $sliderProduct['id'])) ?>">Voir la référence →</a></div>
            </article>
        <?php endforeach; ?>
    </div>
    <button class="global-slider-arrow global-prev" type="button" aria-label="Référence précédente">‹</button>
    <button class="global-slider-arrow global-next" type="button" aria-label="Référence suivante">›</button>
    <div class="global-slider-progress"><span class="global-slider-current">1</span><i>/</i><span><?= count($globalSliderProducts) ?></span></div>
</section>
<?php endif; ?>
