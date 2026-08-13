<?php

declare(strict_types=1);
session_start();
require dirname(__DIR__) . '/app/Database.php';
require dirname(__DIR__) . '/app/helpers.php';
$brandSlides = [
    ['brand'=>'Kaspersky','title'=>'Protégez chaque poste contre les cybermenaces.','text'=>'Antivirus, EDR et sécurité avancée pour les entreprises.','query'=>'Kaspersky','badge'=>'Protection endpoint','accent'=>'#20b86a','accent2'=>'#087a50','icon'=>'◆','nodes'=>['POSTES','EDR','MENACES']],
    ['brand'=>'Fortinet','title'=>'Sécurisez et connectez tous vos sites.','text'=>'Firewalls FortiGate, UTP et protection réseau nouvelle génération.','query'=>'Fortinet','badge'=>'Sécurité réseau','accent'=>'#ee3124','accent2'=>'#9e1913','icon'=>'⬡','nodes'=>['INTERNET','FORTIGATE','LAN / VPN']],
    ['brand'=>'Microsoft','title'=>'Donnez plus de puissance à vos équipes.','text'=>'Microsoft 365, Windows et solutions cloud pour votre entreprise.','query'=>'Microsoft','badge'=>'Productivité cloud','accent'=>'#2589e8','accent2'=>'#1257a6','icon'=>'⊞','nodes'=>['UTILISATEURS','MICROSOFT 365','CLOUD']],
    ['brand'=>'Windows Server','title'=>'Construisez une infrastructure fiable et performante.','text'=>'Windows Server, CAL et accès RDS adaptés à vos besoins.','query'=>'Windows Server','badge'=>'Infrastructure serveur','accent'=>'#5b6cf0','accent2'=>'#303f9f','icon'=>'▤','nodes'=>['CLIENTS','WINDOWS SERVER','RDS / DATA']],
    ['brand'=>'Veeam','title'=>'Restaurez vos données quand chaque seconde compte.','text'=>'Sauvegarde, réplication et reprise rapide de vos workloads.','query'=>'Veeam','badge'=>'Backup & réplication','accent'=>'#00b58b','accent2'=>'#087563','icon'=>'↻','nodes'=>['WORKLOADS','VEEAM BACKUP','RESTORE']],
    ['brand'=>'Acronis','title'=>'Réunissez sauvegarde et cybersécurité.','text'=>'Protection cloud centralisée des postes, serveurs et données.','query'=>'Acronis','badge'=>'Cyber Protect Cloud','accent'=>'#4466dd','accent2'=>'#243b91','icon'=>'△','nodes'=>['APPAREILS','CYBER PROTECT','CLOUD']],
    ['brand'=>'Axcient','title'=>'Assurez la continuité de votre activité.','text'=>'Disaster Recovery et restauration après incident ou ransomware.','query'=>'Axcient','badge'=>'PRA & continuité','accent'=>'#ff6b35','accent2'=>'#a63a16','icon'=>'∞','nodes'=>['PRODUCTION','X360 RECOVER','PRA']],
    ['brand'=>'Sage','title'=>'Pilotez votre entreprise avec précision.','text'=>'Comptabilité, gestion commerciale, facturation et trésorerie.','query'=>'Sage','badge'=>'Gestion d’entreprise','accent'=>'#00a376','accent2'=>'#00674d','icon'=>'S','nodes'=>['VENTES','SAGE 100','FINANCE']],
    ['brand'=>'Sophos','title'=>'Bloquez les attaques avant leur impact.','text'=>'Endpoint, Intercept X et protection synchronisée des entreprises.','query'=>'Sophos','badge'=>'Sécurité synchronisée','accent'=>'#168bd2','accent2'=>'#07578d','icon'=>'⬢','nodes'=>['ENDPOINT','SOPHOS CENTRAL','FIREWALL']],
    ['brand'=>'Bitdefender','title'=>'Déployez une défense simple et intelligente.','text'=>'GravityZone protège vos utilisateurs, appareils et workloads.','query'=>'Bitdefender','badge'=>'GravityZone Business','accent'=>'#d9252a','accent2'=>'#861317','icon'=>'B','nodes'=>['DEVICES','GRAVITYZONE','ANALYTICS']],
];
$pageTitle = 'Solutions IT, cybersécurité et cloud';
require __DIR__ . '/partials/header.php';
?>
<section class="hero brand-hero-slider" aria-label="Marques et produits" aria-roledescription="carrousel">
    <div class="brand-hero-track">
        <?php foreach ($brandSlides as $slideIndex => $slide): ?>
            <article class="brand-hero-slide<?= $slideIndex === 0 ? ' active' : '' ?>" style="--brand-accent:<?= e($slide['accent']) ?>;--brand-accent-2:<?= e($slide['accent2']) ?>" data-brand-slide="<?= $slideIndex ?>" aria-hidden="<?= $slideIndex === 0 ? 'false' : 'true' ?>">
                <div class="hero-copy">
                    <span class="eyebrow"><?= e(strtoupper($slide['brand'])) ?> • PARTENAIRE DISTRITECH</span>
                    <h1><?= e($slide['title']) ?></h1>
                    <p><?= e($slide['text']) ?></p>
                    <div class="actions"><a class="button primary" href="<?= e(url('products.php?q=' . rawurlencode($slide['query']))) ?>">Voir les produits <?= e($slide['brand']) ?></a><a class="button ghost" href="<?= e(url('quote.php')) ?>">Demander un devis</a></div>
                    <div class="trust"><span>Conseil expert</span><span>Déploiement professionnel</span><span>Support local</span></div>
                </div>
                <div class="hero-art brand-product-art">
                    <div class="brand-image-stage brand-schema" role="img" aria-label="Schéma de la solution <?= e($slide['brand']) ?>">
                        <div class="brand-wordmark"><i><?= e($slide['icon']) ?></i><strong><?= e($slide['brand']) ?></strong><small><?= e($slide['badge']) ?></small></div>
                        <div class="schema-flow">
                            <?php foreach ($slide['nodes'] as $nodeIndex => $node): ?><div class="schema-node<?= $nodeIndex === 1 ? ' schema-core' : '' ?>"><span><?= $nodeIndex === 0 ? '◉' : ($nodeIndex === 1 ? $slide['icon'] : '✓') ?></span><b><?= e($node) ?></b></div><?php if ($nodeIndex < 2): ?><i class="schema-link"><em></em></i><?php endif; ?><?php endforeach; ?>
                        </div>
                        <div class="schema-status"><span></span>Architecture sécurisée • Supervision active</div>
                    </div>
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
