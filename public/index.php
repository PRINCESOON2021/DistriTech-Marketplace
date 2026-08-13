<?php

declare(strict_types=1);
session_start();
require dirname(__DIR__) . '/app/Database.php';
require dirname(__DIR__) . '/app/helpers.php';
$brandSlides = [
    ['brand'=>'Kaspersky','title'=>'Protégez chaque poste contre les cybermenaces.','text'=>'Antivirus, EDR et sécurité avancée pour les entreprises.','image'=>'kaspersky.webp','query'=>'Kaspersky','badge'=>'Protection endpoint'],
    ['brand'=>'Fortinet','title'=>'Sécurisez et connectez tous vos sites.','text'=>'Firewalls FortiGate, UTP et protection réseau nouvelle génération.','image'=>'fortigate.webp','query'=>'Fortinet','badge'=>'Sécurité réseau'],
    ['brand'=>'Microsoft','title'=>'Donnez plus de puissance à vos équipes.','text'=>'Microsoft 365, Windows et solutions cloud pour votre entreprise.','image'=>'microsoft.webp','query'=>'Microsoft','badge'=>'Productivité cloud'],
    ['brand'=>'Windows Server','title'=>'Construisez une infrastructure fiable et performante.','text'=>'Windows Server, CAL et accès RDS adaptés à vos besoins.','image'=>'windows-server.webp','query'=>'Windows Server','badge'=>'Infrastructure serveur'],
    ['brand'=>'Veeam','title'=>'Restaurez vos données quand chaque seconde compte.','text'=>'Sauvegarde, réplication et reprise rapide de vos workloads.','image'=>'veeam.webp','query'=>'Veeam','badge'=>'Backup & réplication'],
    ['brand'=>'Acronis','title'=>'Réunissez sauvegarde et cybersécurité.','text'=>'Protection cloud centralisée des postes, serveurs et données.','image'=>'acronis.webp','query'=>'Acronis','badge'=>'Cyber Protect Cloud'],
    ['brand'=>'Axcient','title'=>'Assurez la continuité de votre activité.','text'=>'Disaster Recovery et restauration après incident ou ransomware.','image'=>'axcient.webp','query'=>'Axcient','badge'=>'PRA & continuité'],
    ['brand'=>'Sage','title'=>'Pilotez votre entreprise avec précision.','text'=>'Comptabilité, gestion commerciale, facturation et trésorerie.','image'=>'sage.webp','query'=>'Sage','badge'=>'Gestion d’entreprise'],
    ['brand'=>'Sophos','title'=>'Bloquez les attaques avant leur impact.','text'=>'Endpoint, Intercept X et protection synchronisée des entreprises.','image'=>'sophos.webp','query'=>'Sophos','badge'=>'Sécurité synchronisée'],
    ['brand'=>'Bitdefender','title'=>'Déployez une défense simple et intelligente.','text'=>'GravityZone protège vos utilisateurs, appareils et workloads.','image'=>'bitdefender.webp','query'=>'Bitdefender','badge'=>'GravityZone Business'],
];
$pageTitle = 'Solutions IT, cybersécurité et cloud';
require __DIR__ . '/partials/header.php';
?>
<section class="hero brand-hero-slider" aria-label="Marques et produits" aria-roledescription="carrousel">
    <div class="brand-hero-track">
        <?php foreach ($brandSlides as $slideIndex => $slide): ?>
            <article class="brand-hero-slide<?= $slideIndex === 0 ? ' active' : '' ?>" data-brand-slide="<?= $slideIndex ?>" aria-hidden="<?= $slideIndex === 0 ? 'false' : 'true' ?>">
                <div class="hero-copy">
                    <span class="eyebrow"><?= e(strtoupper($slide['brand'])) ?> • PARTENAIRE DISTRITECH</span>
                    <h1><?= e($slide['title']) ?></h1>
                    <p><?= e($slide['text']) ?></p>
                    <div class="actions"><a class="button primary" href="<?= e(url('products.php?q=' . rawurlencode($slide['query']))) ?>">Voir les produits <?= e($slide['brand']) ?></a><a class="button ghost" href="<?= e(url('quote.php')) ?>">Demander un devis</a></div>
                    <div class="trust"><span>Conseil expert</span><span>Déploiement professionnel</span><span>Support local</span></div>
                </div>
                <div class="hero-art brand-product-art">
                    <img src="<?= e(url('assets/images/products/' . $slide['image'])) ?>" alt="Produits <?= e($slide['brand']) ?>" <?= $slideIndex === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>>
                    <div class="floating-card card-security"><span class="pulse-dot"></span><div><b><?= e($slide['brand']) ?></b><small>Solution professionnelle</small></div></div>
                    <div class="floating-card card-backup"><span>✓</span><div><b><?= e($slide['badge']) ?></b><small>Disponible chez DISTRITECH</small></div></div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    <button class="brand-hero-arrow brand-hero-prev" type="button" aria-label="Marque précédente">‹</button>
    <button class="brand-hero-arrow brand-hero-next" type="button" aria-label="Marque suivante">›</button>
    <div class="brand-hero-dots" role="tablist" aria-label="Choisir une marque"><?php foreach ($brandSlides as $slideIndex => $slide): ?><button class="<?= $slideIndex === 0 ? 'active' : '' ?>" type="button" data-brand-dot="<?= $slideIndex ?>" aria-label="<?= e($slide['brand']) ?>" aria-pressed="<?= $slideIndex === 0 ? 'true' : 'false' ?>"></button><?php endforeach; ?></div>
</section>

<section class="brand-marquee" aria-label="Éditeurs et technologies"><div class="marquee-track"><span>MICROSOFT</span><span>FORTINET</span><span>KASPERSKY</span><span>VEEAM</span><span>ACRONIS</span><span>SAGE</span><span>AXCIENT</span><span>BACKBLAZE</span><span aria-hidden="true">MICROSOFT</span><span aria-hidden="true">FORTINET</span><span aria-hidden="true">KASPERSKY</span><span aria-hidden="true">VEEAM</span></div></section>

<section class="proof-strip reveal"><div><strong>360°</strong><span>Protection globale</span></div><div><strong>9</strong><span>Catégories IT</span></div><div><strong>24/7</strong><span>Monitoring disponible</span></div><div><strong>Maroc</strong><span>Accompagnement local</span></div></section>

<section class="section solutions-showcase reveal" id="solutions">
    <div class="section-heading"><div><span class="eyebrow">NOS SOLUTIONS</span><h2>L’essentiel pour votre système d’information.</h2></div><p>Découvrez brièvement chaque expertise, puis consultez les produits correspondants.</p></div>
    <div class="home-solution-grid">
        <article><span class="solution-mark"><b>01</b>◆</span><h3>Cybersécurité</h3><p>Antivirus, EDR et protection avancée contre les menaces et ransomwares.</p><div><a href="<?= e(url('products.php?category=cybersecurite')) ?>">Liste des produits <i>→</i></a></div></article>
        <article><span class="solution-mark"><b>02</b>⌁</span><h3>Firewall & réseau</h3><p>Sécurisez les accès, les sites distants et les échanges de votre entreprise.</p><div><a href="<?= e(url('products.php?category=firewall')) ?>">Liste des produits <i>→</i></a></div></article>
        <article><span class="solution-mark"><b>03</b>☁</span><h3>Microsoft & Cloud</h3><p>Microsoft 365, Windows, serveurs et services cloud pour vos équipes.</p><div><a href="<?= e(url('products.php?category=microsoft')) ?>">Liste des produits <i>→</i></a></div></article>
        <article><span class="solution-mark"><b>04</b>↻</span><h3>Backup & PRA</h3><p>Sauvegarde, réplication et reprise rapide après incident informatique.</p><div><a href="<?= e(url('products.php?category=backup')) ?>">Liste des produits <i>→</i></a></div></article>
        <article><span class="solution-mark"><b>05</b>▦</span><h3>Gestion Sage</h3><p>Solutions de comptabilité, gestion commerciale et pilotage d’entreprise.</p><div><a href="<?= e(url('products.php?category=sage')) ?>">Liste des produits <i>→</i></a></div></article>
        <article><span class="solution-mark"><b>06</b>✦</span><h3>Services managés</h3><p>Audit, déploiement, supervision, maintenance et support informatique.</p><div><a href="<?= e(url('products.php')) ?>">Liste des produits <i>→</i></a></div></article>
    </div>
</section>

<section class="dark-section reveal"><span class="eyebrow">SOLUTIONS MÉTIERS</span><h2>Une réponse complète à chaque enjeu.</h2><div class="solution-grid"><article id="expertise-security"><span class="solution-icon">◇</span><b>Protection ransomware</b><p>EDR, firewall, copie immuable et plan de restauration.</p><a href="<?= e(url('products.php?category=cybersecurite')) ?>">Voir les produits →</a></article><article id="expertise-network"><span class="solution-icon">⌁</span><b>Interconnexion multi-sites</b><p>VPN, SD-WAN et accès cloud sécurisés.</p><a href="<?= e(url('products.php?category=firewall')) ?>">Voir les produits →</a></article><article id="expertise-backup"><span class="solution-icon">↻</span><b>Continuité d’activité</b><p>Backup, PRA et reprise rapide des workloads.</p><a href="<?= e(url('products.php?category=backup')) ?>">Voir les produits →</a></article></div></section>

<section class="section reveal" id="services"><div class="section-heading"><div><span class="eyebrow">SERVICES DISTRITECH</span><h2>De l’audit au support continu.</h2></div><p>Une équipe unique pilote vos solutions, du cadrage initial au maintien en conditions opérationnelles.</p></div><div class="service-grid"><article><span>01</span><h3>Audit & conseil</h3><p>Analyse de l’existant et feuille de route adaptée.</p></article><article><span>02</span><h3>Installation</h3><p>Paramétrage, migration et mise en production.</p></article><article><span>03</span><h3>MSP & maintenance</h3><p>Monitoring, support, sécurité et rapports réguliers.</p></article></div></section>

<section class="cta-band reveal"><div><span class="eyebrow">PARLONS DE VOTRE PROJET</span><h2>Recevez une proposition adaptée à votre entreprise.</h2></div><a class="button light" href="<?= e(url('quote.php')) ?>">Demander un devis</a></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
