<?php

declare(strict_types=1);

$config = require __DIR__ . '/../config/database.php';
$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $config['host'], $config['port'], $config['database'], $config['charset']);

try {
    $pdo = new PDO($dsn, $config['username'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    $category = trim($_GET['category'] ?? '');
    $search = trim($_GET['q'] ?? '');
    $sql = 'SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON c.id=p.category_id WHERE p.is_active=1';
    $params = [];
    if ($category !== '') { $sql .= ' AND c.slug=:category'; $params['category'] = $category; }
    if ($search !== '') { $sql .= ' AND (p.name LIKE :q OR p.brand LIKE :q OR p.sku LIKE :q)'; $params['q'] = '%' . $search . '%'; }
    $sql .= ' ORDER BY p.is_featured DESC, p.name ASC';
    $stmt = $pdo->prepare($sql); $stmt->execute($params); $products = $stmt->fetchAll();
    $categories = $pdo->query('SELECT name,slug FROM categories WHERE is_active=1 ORDER BY sort_order')->fetchAll();
} catch (Throwable $e) {
    http_response_code(500); exit('Base de données indisponible. Importez database/schema.sql puis configurez la connexion.');
}
function e(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Catalogue — DistriTech</title><style>
body{margin:0;background:#f6f8fb;color:#152235;font-family:Arial,sans-serif}.nav{background:#07111f;padding:20px 5%;color:#fff}.nav a{color:#dce7f5;text-decoration:none;margin-right:22px}.wrap{max-width:1200px;margin:auto;padding:45px 24px}.tools{display:flex;gap:12px;flex-wrap:wrap;margin:25px 0}.tools input,.tools select{padding:13px;border:1px solid #d8e0ea;border-radius:8px;background:#fff}.tools input{min-width:280px}.btn{padding:13px 18px;border:0;border-radius:8px;background:#0b89ad;color:#fff;font-weight:bold}.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.card{background:#fff;border:1px solid #e0e6ee;border-radius:14px;padding:22px}.brand{font-size:13px;color:#748397}.card h3{margin:8px 0}.desc{color:#65748a;line-height:1.5;min-height:46px}.price{font-size:21px;font-weight:800;margin:16px 0}.meta{font-size:13px;color:#66758a}.tag{display:inline-block;padding:5px 8px;border-radius:20px;background:#eef8fb;color:#087b99;font-size:12px}@media(max-width:800px){.grid{grid-template-columns:1fr 1fr}}@media(max-width:520px){.grid{grid-template-columns:1fr}.tools input{min-width:100%}}
</style></head><body><nav class="nav"><strong>DistriTech</strong> &nbsp; <a href="index.php">Accueil</a><a href="catalog.php">Catalogue</a><a href="#">Solutions</a><a href="#">Services</a></nav><main class="wrap"><h1>Catalogue produits</h1><p>Licences, abonnements, cloud et solutions IT professionnelles.</p><form class="tools" method="get"><input name="q" value="<?=e($search)?>" placeholder="Rechercher produit, marque ou SKU..."><select name="category"><option value="">Toutes les catégories</option><?php foreach($categories as $c): ?><option value="<?=e($c['slug'])?>" <?=$category===$c['slug']?'selected':''?>><?=e($c['name'])?></option><?php endforeach; ?></select><button class="btn">Rechercher</button></form><div class="grid"><?php foreach($products as $p): ?><article class="card"><span class="tag"><?=e($p['category_name'])?></span><div class="brand"><?=e($p['brand'] ?? '')?> · <?=e($p['sku'])?></div><h3><?=e($p['name'])?></h3><p class="desc"><?=e($p['description'] ?? '')?></p><div class="meta">Version : <?=e($p['version'] ?? '—')?> · Unité : <?=e($p['unit'] ?? '—')?></div><div class="price"><?php if($p['target_price'] !== null): ?><?=number_format((float)$p['target_price'],2,',',' ')?> DH<?php else: ?>Sur devis<?php endif; ?></div><a class="btn" href="quote.php?product=<?=urlencode($p['id'])?>">Demander un devis</a></article><?php endforeach; ?></div></main></body></html>
