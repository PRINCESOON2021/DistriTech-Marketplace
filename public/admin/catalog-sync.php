<?php
require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();
$pdo = admin_db();

$catalog = [
 ['cybersecurite','KAS-STD','Kaspersky Standard','Kaspersky','Standard','1 à 10 postes','Abonnement annuel','poste/an',690,'Protection antivirus essentielle.'],
 ['cybersecurite','KAS-PLUS','Kaspersky Plus','Kaspersky','Plus','1 à 10 postes','Abonnement annuel','poste/an',890,'Protection avancée avec confidentialité et VPN.'],
 ['cybersecurite','KAS-PREM','Kaspersky Premium','Kaspersky','Premium','1 à 10 postes','Abonnement annuel','poste/an',1090,'Protection premium des postes et utilisateurs.'],
 ['cybersecurite','KAS-EDR-FND','Kaspersky Next EDR Foundations','Kaspersky','Foundations','À partir de 10 postes','Abonnement annuel','poste/an',null,'Sécurité endpoint professionnelle administrée.'],
 ['cybersecurite','SOP-ENDPOINT','Sophos Endpoint','Sophos','Business','Par utilisateur','Abonnement annuel','utilisateur/an',null,'Protection centralisée des postes professionnels.'],
 ['cybersecurite','SOP-INTERCEPT-X','Sophos Intercept X','Sophos','Advanced','Par utilisateur','Abonnement annuel','utilisateur/an',null,'Protection anti-ransomware et anti-exploit.'],
 ['cybersecurite','MS-DEF-BUS','Microsoft Defender for Business','Microsoft','Business','1 utilisateur','Abonnement annuel','utilisateur/an',null,'EDR Microsoft conçu pour les PME.'],
 ['cybersecurite','BIT-GZ-BUS','Bitdefender GravityZone Business Security','Bitdefender','Business Security','À partir de 10 postes','Abonnement annuel','poste/an',null,'Protection endpoint multicouche pour PME.'],
 ['firewall','FTG-40F-BDL','FortiGate 40F Security Bundle','Fortinet','UTP','TPE / agence','Appliance + licence','unité',null,'Firewall compact avec services FortiGuard.'],
 ['firewall','FTG-60F-BDL','FortiGate 60F Security Bundle','Fortinet','UTP','PME','Appliance + licence','unité',null,'Firewall nouvelle génération pour PME.'],
 ['firewall','FTG-80F-BDL','FortiGate 80F Security Bundle','Fortinet','UTP','PME multi-sites','Appliance + licence','unité',null,'Sécurité et SD-WAN pour entreprises multisites.'],
 ['firewall','FTG-100F-BDL','FortiGate 100F Security Bundle','Fortinet','UTP','Entreprise','Appliance + licence','unité',null,'Firewall haute performance pour entreprise.'],
 ['firewall','FTG-200F-BDL','FortiGate 200F Security Bundle','Fortinet','Enterprise','Entreprise','Appliance + licence','unité',null,'Protection réseau pour infrastructures exigeantes.'],
 ['firewall','SOP-XGS-87','Sophos XGS 87','Sophos','Xstream Protection','TPE','Appliance + licence','unité',null,'Firewall Sophos compact pour petite structure.'],
 ['firewall','SOP-XGS-107','Sophos XGS 107','Sophos','Xstream Protection','PME','Appliance + licence','unité',null,'Firewall et sécurité synchronisée Sophos.'],
 ['microsoft','M365-BASIC','Microsoft 365 Business Basic','Microsoft','Business Basic','1 utilisateur','Abonnement annuel','utilisateur/an',890,'Messagerie professionnelle et applications cloud.'],
 ['microsoft','M365-STD','Microsoft 365 Business Standard','Microsoft','Business Standard','1 utilisateur','Abonnement annuel','utilisateur/an',1690,'Applications Office, e-mail et collaboration.'],
 ['microsoft','MS-INTUNE','Microsoft Intune Plan 1','Microsoft','Plan 1','1 utilisateur','Abonnement annuel','utilisateur/an',null,'Gestion sécurisée des appareils et applications.'],
 ['microsoft','MS-ENTRA-P1','Microsoft Entra ID P1','Microsoft','P1','1 utilisateur','Abonnement annuel','utilisateur/an',null,'Gestion des identités et accès conditionnel.'],
 ['microsoft','MS-DEF-O365-P1','Defender for Office 365 Plan 1','Microsoft','Plan 1','1 utilisateur','Abonnement annuel','utilisateur/an',null,'Protection des e-mails contre phishing et malware.'],
 ['microsoft','WIN11-PRO','Windows 11 Pro','Microsoft','Professional','1 appareil','Licence perpétuelle','appareil',null,'Système d’exploitation professionnel sécurisé.'],
 ['microsoft','WS2025-STD','Windows Server 2025 Standard','Microsoft','Standard','16 cœurs','Licence serveur','serveur',null,'Plateforme serveur pour PME et virtualisation.'],
 ['microsoft','WS-CAL-U','Windows Server User CAL','Microsoft','2025','1 utilisateur','Licence perpétuelle','utilisateur',650,'Droit d’accès utilisateur à Windows Server.'],
 ['microsoft','WS-CAL-D','Windows Server Device CAL','Microsoft','2025','1 appareil','Licence perpétuelle','appareil',650,'Droit d’accès appareil à Windows Server.'],
 ['microsoft','RDS-CAL-D','Windows Server RDS Device CAL','Microsoft','2025','1 appareil','Licence perpétuelle','appareil',1400,'Droit d’accès RDS par appareil.'],
 ['backup','VEEAM-M365','Veeam Backup for Microsoft 365','Veeam','V8','1 utilisateur','Abonnement annuel','utilisateur/an',null,'Sauvegarde indépendante de Microsoft 365.'],
 ['backup','ACR-CYBER-PROTECT','Acronis Cyber Protect','Acronis','Advanced','Par workload','Abonnement annuel','workload/an',null,'Backup, antimalware et protection endpoint.'],
 ['backup','NAKIVO-PRO','NAKIVO Backup & Replication Pro','NAKIVO','Pro','Par workload','Abonnement annuel','workload/an',null,'Sauvegarde et réplication pour VM et serveurs.'],
 ['backup','AXC-DTC','Axcient Direct-to-Cloud','Axcient','Direct-to-Cloud','Par workload','Abonnement annuel','workload/an',null,'Sauvegarde directe dans le cloud Axcient.'],
 ['cloud-baas','BBL-BUS','Backblaze Business Backup','Backblaze','Business','1 poste','Abonnement annuel','poste/an',799,'Sauvegarde cloud continue des postes.'],
 ['cloud-baas','VEEAM-CC','Veeam Cloud Connect','Veeam','Cloud Connect','Par workload','Abonnement','workload/mois',null,'Copie de sauvegarde externalisée et sécurisée.'],
 ['pra','VEEAM-DRAAS','Veeam DRaaS','Veeam','DRaaS','Par workload','Service managé','workload/mois',null,'Reprise d’activité Veeam dans le cloud.'],
 ['pra','ACR-DR','Acronis Disaster Recovery','Acronis','Disaster Recovery','Par workload','Service cloud','workload/mois',null,'Reprise cloud orchestrée après incident.'],
 ['pra','AXC-DR','Axcient Disaster Recovery','Axcient','x360Recover','Par workload','Service cloud','workload/an',null,'Continuité et récupération après sinistre.'],
 ['sage','SAGE100-PAIE','Sage 100 Paie & RH','Sage','Sage 100','1 à 10 utilisateurs','Selon configuration','licence',null,'Paie, déclarations sociales et gestion RH.'],
 ['sage','SAGE100-SUITE','Sage 100 Suite','Sage','Sage 100','1 à 20 utilisateurs','Selon configuration','licence',null,'Suite intégrée comptabilité, gestion et paie.'],
 ['msp','MSP-BACKUP','Backup managé DISTRITECH','DISTRITECH','BaaS','Par parc','Contrat mensuel','mois',null,'Sauvegarde, surveillance et tests de restauration.'],
 ['msp','MSP-SECURITY','Cybersécurité managée DISTRITECH','DISTRITECH','MSSP','Par parc','Contrat mensuel','mois',null,'Endpoint, firewall, monitoring et reporting.'],
];

$added = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 verify_csrf();
 $category = $pdo->prepare('SELECT id FROM categories WHERE slug=:slug');
 $insert = $pdo->prepare('INSERT IGNORE INTO products(category_id,sku,name,brand,version,users_label,license_type,unit,sale_price,quote_only,featured,short_description,active) VALUES(:category_id,:sku,:name,:brand,:version,:users,:license,:unit,:price,:quote_only,0,:description,1)');
 foreach ($catalog as $p) {
  $category->execute(['slug'=>$p[0]]); $categoryId=(int)$category->fetchColumn(); if(!$categoryId) continue;
  $insert->execute(['category_id'=>$categoryId,'sku'=>$p[1],'name'=>$p[2],'brand'=>$p[3],'version'=>$p[4],'users'=>$p[5],'license'=>$p[6],'unit'=>$p[7],'price'=>$p[8],'quote_only'=>$p[8]===null?1:0,'description'=>$p[9]]);
  $added += $insert->rowCount();
 }
}
$current=(int)$pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
admin_header('Catalogue complet'); ?>
<div class="admin-title"><div><span class="kicker">IMPORT CATALOGUE</span><h1>Produits populaires</h1><p><?= $current ?> références actuellement dans la base</p></div><a href="index.php">← Produits</a></div>
<?php if($_SERVER['REQUEST_METHOD']==='POST'): ?><div class="alert success"><?= $added ?> nouveaux produits ajoutés. Les références déjà présentes ont été conservées.</div><?php endif; ?>
<section class="auth-card" style="max-width:700px;margin:0"><h2>Ajouter <?= count($catalog) ?> références préparées</h2><p>Antivirus, firewall, Microsoft, CAL/RDS, backup, cloud, PRA, Sage et services MSP.</p><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><button class="admin-button">Importer le catalogue complet</button></form></section>
<?php admin_footer(); ?>
