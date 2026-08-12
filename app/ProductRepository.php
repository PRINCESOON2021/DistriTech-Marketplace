<?php

declare(strict_types=1);

final class ProductRepository
{
    public function all(string $search = '', string $category = ''): array
    {
        $pdo = Database::connection();
        if ($pdo instanceof PDO) {
            $sql = 'SELECT p.*, c.name AS category_name, c.slug AS category_slug
                    FROM products p JOIN categories c ON c.id = p.category_id
                    WHERE p.active = 1';
            $params = [];
            if ($search !== '') {
                $sql .= ' AND (p.name LIKE :search OR p.brand LIKE :search OR p.sku LIKE :search)';
                $params['search'] = '%' . $search . '%';
            }
            if ($category !== '') {
                $sql .= ' AND c.slug = :category';
                $params['category'] = $category;
            }
            $sql .= ' ORDER BY p.featured DESC, p.name ASC';
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            return $statement->fetchAll();
        }

        return array_values(array_filter($this->fallbackProducts(), static function (array $product) use ($search, $category): bool {
            $haystack = mb_strtolower($product['name'] . ' ' . $product['brand'] . ' ' . $product['sku']);
            return ($search === '' || str_contains($haystack, mb_strtolower($search)))
                && ($category === '' || $product['category_slug'] === $category);
        }));
    }

    public function find(int $id): ?array
    {
        foreach ($this->all() as $product) {
            if ((int) $product['id'] === $id) {
                return $product;
            }
        }
        return null;
    }

    public function categories(): array
    {
        $pdo = Database::connection();
        if ($pdo instanceof PDO) {
            return $pdo->query('SELECT id, name, slug FROM categories WHERE active = 1 ORDER BY position, name')->fetchAll();
        }

        $categories = [];
        foreach ($this->fallbackProducts() as $product) {
            $categories[$product['category_slug']] = [
                'id' => count($categories) + 1,
                'name' => $product['category_name'],
                'slug' => $product['category_slug'],
            ];
        }
        return array_values($categories);
    }

    private function fallbackProducts(): array
    {
        return [
            ['id'=>1,'sku'=>'KAS-EDR-OPT','name'=>'Kaspersky Next EDR Optimum','brand'=>'Kaspersky','category_name'=>'Cybersécurité','category_slug'=>'cybersecurite','version'=>'Optimum','users_label'=>'10 postes','license_type'=>'Abonnement annuel','unit'=>'poste/an','sale_price'=>null,'quote_only'=>1,'featured'=>1,'short_description'=>'Protection EDR avancée pour les PME.'],
            ['id'=>2,'sku'=>'FTG-70F-BDL','name'=>'FortiGate 70F Security Bundle','brand'=>'Fortinet','category_name'=>'Firewall','category_slug'=>'firewall','version'=>'UTP','users_label'=>'PME','license_type'=>'Appliance + licence','unit'=>'unité','sale_price'=>null,'quote_only'=>1,'featured'=>1,'short_description'=>'Firewall nouvelle génération avec services FortiGuard.'],
            ['id'=>3,'sku'=>'M365-BP','name'=>'Microsoft 365 Business Premium','brand'=>'Microsoft','category_name'=>'Microsoft','category_slug'=>'microsoft','version'=>'Business Premium','users_label'=>'1 utilisateur','license_type'=>'Abonnement annuel','unit'=>'utilisateur/an','sale_price'=>2490,'quote_only'=>0,'featured'=>1,'short_description'=>'Productivité, sécurité et gestion des appareils pour PME.'],
            ['id'=>4,'sku'=>'RDS-CAL-U','name'=>'Windows Server RDS User CAL','brand'=>'Microsoft','category_name'=>'Microsoft','category_slug'=>'microsoft','version'=>'2025','users_label'=>'1 utilisateur','license_type'=>'Licence perpétuelle','unit'=>'utilisateur','sale_price'=>1400,'quote_only'=>0,'featured'=>0,'short_description'=>'Droit d’accès utilisateur aux services Remote Desktop.'],
            ['id'=>5,'sku'=>'VEEAM-DP','name'=>'Veeam Data Platform Essentials','brand'=>'Veeam','category_name'=>'Backup','category_slug'=>'backup','version'=>'Essentials','users_label'=>'5 workloads','license_type'=>'Abonnement','unit'=>'pack/an','sale_price'=>null,'quote_only'=>1,'featured'=>1,'short_description'=>'Sauvegarde et restauration pour environnements PME.'],
            ['id'=>6,'sku'=>'ACR-CPC','name'=>'Acronis Cyber Protect Cloud','brand'=>'Acronis','category_name'=>'Cloud & BaaS','category_slug'=>'cloud-baas','version'=>'Advanced','users_label'=>'Par workload','license_type'=>'Abonnement mensuel','unit'=>'workload/mois','sale_price'=>null,'quote_only'=>1,'featured'=>1,'short_description'=>'Backup cloud, antimalware et gestion centralisée.'],
            ['id'=>7,'sku'=>'AXC-X360','name'=>'Axcient x360Recover','brand'=>'Axcient','category_name'=>'PRA & Disaster Recovery','category_slug'=>'pra','version'=>'Direct-to-Cloud','users_label'=>'Par workload','license_type'=>'Abonnement annuel','unit'=>'workload/an','sale_price'=>null,'quote_only'=>1,'featured'=>1,'short_description'=>'Continuité d’activité et restauration après ransomware.'],
            ['id'=>8,'sku'=>'BBL-B2-1T','name'=>'Backblaze B2 Cloud Storage','brand'=>'Backblaze','category_name'=>'Cloud & BaaS','category_slug'=>'cloud-baas','version'=>'S3 Compatible','users_label'=>'1 To','license_type'=>'Consommation','unit'=>'To/mois','sale_price'=>110,'quote_only'=>0,'featured'=>0,'short_description'=>'Stockage objet S3 compatible pour copies hors site.'],
            ['id'=>9,'sku'=>'SAGE100-CPT','name'=>'Sage 100 Comptabilité','brand'=>'Sage','category_name'=>'Sage','category_slug'=>'sage','version'=>'Sage 100','users_label'=>'1 à 10 utilisateurs','license_type'=>'Selon configuration','unit'=>'licence','sale_price'=>null,'quote_only'=>1,'featured'=>1,'short_description'=>'Comptabilité, TVA, états financiers et trésorerie.'],
            ['id'=>10,'sku'=>'SAGE100-GC','name'=>'Sage 100 Gestion Commerciale','brand'=>'Sage','category_name'=>'Sage','category_slug'=>'sage','version'=>'Sage 100','users_label'=>'1 à 10 utilisateurs','license_type'=>'Selon configuration','unit'=>'licence','sale_price'=>null,'quote_only'=>1,'featured'=>0,'short_description'=>'Ventes, achats, stocks, devis et facturation.'],
            ['id'=>11,'sku'=>'NET-SDWAN','name'=>'Interconnexion SD-WAN Multi-sites','brand'=>'DISTRITECH','category_name'=>'Réseau','category_slug'=>'reseau','version'=>'Sur mesure','users_label'=>'Par site','license_type'=>'Projet','unit'=>'projet','sale_price'=>null,'quote_only'=>1,'featured'=>0,'short_description'=>'Connexion sécurisée entre siège, agences et cloud.'],
            ['id'=>12,'sku'=>'MSP-MANAGED','name'=>'Maintenance & Monitoring MSP','brand'=>'DISTRITECH','category_name'=>'MSP & Maintenance','category_slug'=>'msp','version'=>'SLA personnalisé','users_label'=>'Par parc','license_type'=>'Contrat','unit'=>'mois','sale_price'=>null,'quote_only'=>1,'featured'=>1,'short_description'=>'Supervision, support, patching, backup et sécurité.'],
        ];
    }
}
