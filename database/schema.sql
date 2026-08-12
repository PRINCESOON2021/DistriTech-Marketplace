CREATE DATABASE IF NOT EXISTS distritech_marketplace CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE distritech_marketplace;

CREATE TABLE categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(140) NOT NULL UNIQUE,
  description TEXT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE products (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id INT UNSIGNED NOT NULL,
  sku VARCHAR(50) NOT NULL UNIQUE,
  name VARCHAR(180) NOT NULL,
  slug VARCHAR(200) NOT NULL UNIQUE,
  brand VARCHAR(100) NULL,
  product_type ENUM('license','subscription','cloud','service','hardware') NOT NULL DEFAULT 'license',
  version VARCHAR(100) NULL,
  users_min INT UNSIGNED NULL,
  users_max INT UNSIGNED NULL,
  unit VARCHAR(60) NULL,
  estimated_cost DECIMAL(12,2) NULL,
  target_price DECIMAL(12,2) NULL,
  currency CHAR(3) NOT NULL DEFAULT 'MAD',
  description TEXT NULL,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB;

CREATE TABLE quote_requests (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  company_name VARCHAR(180) NOT NULL,
  contact_name VARCHAR(150) NOT NULL,
  email VARCHAR(180) NOT NULL,
  phone VARCHAR(50) NULL,
  product_id INT UNSIGNED NULL,
  quantity INT UNSIGNED NOT NULL DEFAULT 1,
  message TEXT NULL,
  status ENUM('new','contacted','quoted','closed') NOT NULL DEFAULT 'new',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_quote_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO categories (name,slug,description,sort_order) VALUES
('Antivirus & Cybersécurité','antivirus-cybersecurite','Protection endpoint, EDR, XDR et sécurité.',1),
('Firewall','firewall','Firewall, licences de sécurité et protection réseau.',2),
('Microsoft','microsoft','Microsoft 365, Defender, Intune, Windows Server et CAL.',3),
('Backup','backup','Sauvegarde professionnelle, cloud backup et protection ransomware.',4),
('Cloud & BaaS','cloud-baas','Cloud storage, BaaS et services de sauvegarde.',5),
('Disaster Recovery','disaster-recovery','PRA, DRaaS et récupération après sinistre.',6),
('Réseau & Interconnexion','reseau-interconnexion','VPN, SD-WAN, multi-sites, switching et Wi-Fi.',7),
('Sage','sage','Comptabilité, gestion commerciale, paie et RH.',8),
('MSP & Maintenance','msp-maintenance','Audit, monitoring, support et maintenance sur devis.',9);

INSERT INTO products (category_id,sku,name,slug,brand,product_type,version,unit,estimated_cost,target_price,description,is_featured) VALUES
(1,'KAS-001','Kaspersky Standard','kaspersky-standard','Kaspersky','subscription','Standard','poste/an',350,599,'Protection essentielle pour poste professionnel.',1),
(1,'KAS-002','Kaspersky Plus','kaspersky-plus','Kaspersky','subscription','Plus','poste/an',500,799,'Protection avancée et confidentialité.',1),
(1,'KAS-003','Kaspersky Premium','kaspersky-premium','Kaspersky','subscription','Premium','poste/an',650,999,'Protection premium pour utilisateurs exigeants.',1),
(1,'KAS-004','Kaspersky Next EDR Optimum','kaspersky-next-edr-optimum','Kaspersky','subscription','EDR Optimum','poste/an',900,1500,'Protection EDR professionnelle pour PME.',1),
(2,'FG-001','FortiGate 60F / Security Bundle','fortigate-60f-security','Fortinet','hardware','60F','appliance/an',7000,10500,'Firewall PME avec licences de sécurité.',1),
(2,'FG-002','FortiGate 70F / Security Bundle','fortigate-70f-security','Fortinet','hardware','70F','appliance/an',9000,13500,'Firewall PME et multi-sites.',1),
(2,'SOP-001','Sophos XGS 107','sophos-xgs-107','Sophos','hardware','XGS 107','appliance/an',7500,11000,'Firewall professionnel Sophos.',1),
(3,'M365-001','Microsoft 365 Business Basic','microsoft-365-business-basic','Microsoft','subscription','Business Basic','utilisateur/an',900,1200,'Suite cloud essentielle.',1),
(3,'M365-002','Microsoft 365 Business Standard','microsoft-365-business-standard','Microsoft','subscription','Business Standard','utilisateur/an',1500,2000,'Office et services cloud professionnels.',1),
(3,'M365-003','Microsoft 365 Business Premium','microsoft-365-business-premium','Microsoft','subscription','Business Premium','utilisateur/an',2200,3000,'Productivité + sécurité avancée.',1),
(3,'MS-001','Windows Server CAL','windows-server-cal','Microsoft','license','CAL','utilisateur',450,650,'CAL Windows Server par utilisateur.',1),
(3,'RDS-001','Windows Server RDS CAL','windows-server-rds-cal','Microsoft','license','RDS CAL','utilisateur',1000,1400,'Droit d’accès Remote Desktop Services.',1),
(4,'ACR-001','Acronis Cyber Protect','acronis-cyber-protect','Acronis','subscription','Cyber Protect','poste/an',450,750,'Backup, sécurité et protection ransomware.',1),
(4,'ACR-021','Acronis Backup Cloud','acronis-backup-cloud','Acronis','cloud','Backup Cloud','poste/an',400,700,'Sauvegarde cloud pour offres MSP.',1),
(4,'VEE-001','Veeam Backup','veeam-backup','Veeam','license','Business','workload/an',900,1500,'Sauvegarde et restauration professionnelle.',1),
(4,'AXC-001','Axcient x360Recover','axcient-x360recover','Axcient','cloud','x360Recover','poste/an',500,850,'Backup cloud et récupération ransomware.',1),
(5,'BBL-001','Backblaze B2 Cloud Storage','backblaze-b2','Backblaze','cloud','B2','TB/mois',70,110,'Stockage objet cloud pour backup et workloads.',1),
(6,'AXC-017','Axcient Disaster Recovery','axcient-disaster-recovery','Axcient','service','DR','workload/an',1500,2500,'Disaster Recovery et continuité d’activité.',1),
(7,'NET-001','Interconnexion VPN Site-to-Site','vpn-site-to-site','DistriTech','service','Standard','site',NULL,NULL,'Interconnexion de sites après audit.',1),
(7,'NET-002','SD-WAN Multi-Sites','sdwan-multi-sites','DistriTech','service','Business','site',NULL,NULL,'SD-WAN et interconnexion multi-sites.',1),
(8,'SAGE-001','Sage Comptabilité','sage-comptabilite','Sage','license','Standard','utilisateur/an',2500,3500,'Comptabilité pour TPE/PME. Version et utilisateurs à confirmer selon offre.',1),
(8,'SAGE-002','Sage Gestion Commerciale','sage-gestion-commerciale','Sage','license','Standard','utilisateur/an',2500,3500,'Gestion commerciale et facturation.',1),
(8,'SAGE-003','Sage Comptabilité + Gestion Commerciale','sage-compta-gestion-commerciale','Sage','license','Standard','utilisateur/an',4000,5500,'Solution combinée de gestion.',1),
(9,'MSP-001','Audit informatique & cybersécurité','audit-informatique-cybersecurite','DistriTech','service','Audit','mission',NULL,NULL,'Audit préalable et devis personnalisé.',1),
(9,'MSP-002','Maintenance informatique managée','maintenance-informatique-managee','DistriTech','service','MSP','contrat/an',NULL,NULL,'Monitoring, support et maintenance après audit.',1);
