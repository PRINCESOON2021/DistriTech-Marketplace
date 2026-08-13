<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/app/security.php';
secure_session_start();
require dirname(__DIR__, 2) . '/app/Database.php';
require dirname(__DIR__, 2) . '/app/AdminAuth.php';
require dirname(__DIR__, 2) . '/app/helpers.php';

function admin_db(): PDO
{
    $pdo = Database::connection();
    if (!$pdo) { http_response_code(503); exit('Base MySQL indisponible. Importez database/schema.sql.'); }
    return $pdo;
}
function admin_installed(PDO $pdo): bool
{
    try { return (bool) $pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn(); }
    catch (PDOException $e) { return false; }
}
function admin_header(string $title): void
{
    $logged = AdminAuth::loggedIn();
    ?><!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= e($title) ?> | Admin DISTRITECH</title><link rel="stylesheet" href="../assets/css/admin.css"></head><body><header class="admin-header"><a class="admin-brand" href="index.php">DISTRITECH <small>ADMIN</small></a><?php if ($logged): ?><nav><a href="index.php">Produits</a><a href="product.php">Ajouter</a><a href="catalog-sync.php">Catalogue complet</a><a href="../index.php" target="_blank">Voir le site</a><a href="logout.php">Déconnexion</a></nav><?php endif; ?></header><main class="admin-main"><?php
}
function admin_footer(): void { echo '</main></body></html>'; }
