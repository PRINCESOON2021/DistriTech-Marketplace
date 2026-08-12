CREATE DATABASE IF NOT EXISTS distritech_marketplace CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE distritech_marketplace;

CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    position SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    sku VARCHAR(60) NOT NULL UNIQUE,
    name VARCHAR(180) NOT NULL,
    brand VARCHAR(80) NOT NULL,
    version VARCHAR(100) NULL,
    users_label VARCHAR(100) NULL,
    license_type VARCHAR(100) NULL,
    unit VARCHAR(60) NOT NULL,
    purchase_price DECIMAL(12,2) NULL,
    sale_price DECIMAL(12,2) NULL,
    quote_only TINYINT(1) NOT NULL DEFAULT 0,
    featured TINYINT(1) NOT NULL DEFAULT 0,
    short_description VARCHAR(255) NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_product_category FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB;

CREATE TABLE quote_requests (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    company VARCHAR(160) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(50) NULL,
    message TEXT NULL,
    cart_json JSON NULL,
    status ENUM('new','contacted','quoted','won','lost') NOT NULL DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO categories (name, slug, position) VALUES
('Cybersécurité','cybersecurite',1),('Firewall','firewall',2),('Microsoft','microsoft',3),('Backup','backup',4),('Cloud & BaaS','cloud-baas',5),('PRA & Disaster Recovery','pra',6),('Réseau','reseau',7),('Sage','sage',8),('MSP & Maintenance','msp',9);

INSERT INTO products (category_id,sku,name,brand,version,users_label,license_type,unit,sale_price,quote_only,featured,short_description) VALUES
(1,'KAS-EDR-OPT','Kaspersky Next EDR Optimum','Kaspersky','Optimum','10 postes','Abonnement annuel','poste/an',NULL,1,1,'Protection EDR avancée pour les PME.'),
(2,'FTG-70F-BDL','FortiGate 70F Security Bundle','Fortinet','UTP','PME','Appliance + licence','unité',NULL,1,1,'Firewall nouvelle génération avec services FortiGuard.'),
(3,'M365-BP','Microsoft 365 Business Premium','Microsoft','Business Premium','1 utilisateur','Abonnement annuel','utilisateur/an',2490,0,1,'Productivité, sécurité et gestion des appareils pour PME.'),
(3,'RDS-CAL-U','Windows Server RDS User CAL','Microsoft','2025','1 utilisateur','Licence perpétuelle','utilisateur',1400,0,0,'Droit d’accès utilisateur aux services Remote Desktop.'),
(4,'VEEAM-DP','Veeam Data Platform Essentials','Veeam','Essentials','5 workloads','Abonnement','pack/an',NULL,1,1,'Sauvegarde et restauration pour environnements PME.'),
(5,'ACR-CPC','Acronis Cyber Protect Cloud','Acronis','Advanced','Par workload','Abonnement mensuel','workload/mois',NULL,1,1,'Backup cloud, antimalware et gestion centralisée.'),
(6,'AXC-X360','Axcient x360Recover','Axcient','Direct-to-Cloud','Par workload','Abonnement annuel','workload/an',NULL,1,1,'Continuité d’activité et restauration après ransomware.'),
(5,'BBL-B2-1T','Backblaze B2 Cloud Storage','Backblaze','S3 Compatible','1 To','Consommation','To/mois',110,0,0,'Stockage objet S3 compatible pour copies hors site.'),
(8,'SAGE100-CPT','Sage 100 Comptabilité','Sage','Sage 100','1 à 10 utilisateurs','Selon configuration','licence',NULL,1,1,'Comptabilité, TVA, états financiers et trésorerie.'),
(8,'SAGE100-GC','Sage 100 Gestion Commerciale','Sage','Sage 100','1 à 10 utilisateurs','Selon configuration','licence',NULL,1,0,'Ventes, achats, stocks, devis et facturation.'),
(7,'NET-SDWAN','Interconnexion SD-WAN Multi-sites','DISTRITECH','Sur mesure','Par site','Projet','projet',NULL,1,0,'Connexion sécurisée entre siège, agences et cloud.'),
(9,'MSP-MANAGED','Maintenance & Monitoring MSP','DISTRITECH','SLA personnalisé','Par parc','Contrat','mois',NULL,1,1,'Supervision, support, patching, backup et sécurité.');
