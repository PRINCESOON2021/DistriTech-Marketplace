<?php

declare(strict_types=1);
require dirname(__DIR__) . '/app/security.php';
secure_session_start();
require dirname(__DIR__) . '/app/helpers.php';

$pageTitle = 'Politique de confidentialité';
require __DIR__ . '/partials/header.php';
?>
<section class="legal-hero">
    <span class="eyebrow">VIE PRIVÉE</span>
    <h1>Politique de confidentialité</h1>
    <p>Cette politique explique comment DISTRITECH collecte, utilise et protège les données transmises sur ce site.</p>
</section>
<section class="legal-page">
    <article>
        <p class="legal-updated">Dernière mise à jour : 13 août 2026</p>

        <h2>1. Responsable du traitement</h2>
        <p>DISTRITECH, Maroc, est responsable du traitement des données personnelles collectées à travers ce site. Toute demande relative à vos données peut être envoyée au moyen du formulaire « Demander un devis ».</p>

        <h2>2. Données collectées</h2>
        <p>Lorsque vous demandez un devis, nous pouvons recueillir votre nom, votre société, votre adresse électronique professionnelle, votre numéro de téléphone, votre message et le contenu de votre panier. Le site utilise également un cookie de session strictement nécessaire au panier, à la sécurité des formulaires et à l’administration.</p>

        <h2>3. Finalités</h2>
        <ul><li>Répondre aux demandes de devis et de renseignements.</li><li>Préparer et suivre une proposition commerciale.</li><li>Gérer le panier et le fonctionnement technique du site.</li><li>Prévenir les abus, les fraudes et les tentatives d’accès non autorisé.</li><li>Respecter les obligations légales applicables.</li></ul>

        <h2>4. Destinataires</h2>
        <p>Les données sont accessibles uniquement aux personnes habilitées de DISTRITECH et, lorsque cela est nécessaire, à ses prestataires techniques soumis à des obligations de confidentialité. DISTRITECH ne vend pas vos données personnelles.</p>

        <h2>5. Durée de conservation</h2>
        <p>Les données sont conservées pendant la durée nécessaire au traitement de votre demande, à la relation commerciale et au respect des obligations légales. Elles sont ensuite supprimées, anonymisées ou archivées de manière sécurisée selon les exigences applicables.</p>

        <h2>6. Sécurité</h2>
        <p>DISTRITECH applique des mesures techniques et organisationnelles destinées à protéger les données contre l’accès non autorisé, l’altération, la perte, la divulgation ou la destruction.</p>

        <h2>7. Vos droits</h2>
        <p>Conformément à la loi marocaine n° 09-08, vous pouvez demander l’accès, la rectification ou l’opposition au traitement de vos données personnelles, ainsi que leur suppression lorsqu’elle est applicable. Utilisez le formulaire « Demander un devis » en précisant « Données personnelles » dans votre message. Vous pouvez également saisir la Commission Nationale de contrôle de la protection des Données à caractère Personnel (CNDP).</p>

        <h2>8. Cookies</h2>
        <p>Le site utilise uniquement des cookies techniques nécessaires au maintien de la session, au panier et à la sécurité. Aucun cookie publicitaire n’est installé par le site dans sa configuration actuelle.</p>

        <h2>9. Modification de la politique</h2>
        <p>Cette politique peut être actualisée afin de refléter une évolution du site, des traitements ou des obligations légales. La date de mise à jour figure en haut de cette page.</p>

        <a class="button primary" href="<?= e(url('quote.php')) ?>">Exercer mes droits</a>
    </article>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
