<?php
require __DIR__ . '/bootstrap.php';
$pdo = admin_db();
if (admin_installed($pdo)) { header('Location: login.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = mb_strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'E-mail invalide.';
    elseif (strlen($password) < 12) $error = 'Le mot de passe doit contenir au moins 12 caractères.';
    else {
        $pdo->exec('CREATE TABLE IF NOT EXISTS admin_users (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, email VARCHAR(190) NOT NULL UNIQUE, password_hash VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL DEFAULT 1, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB');
        $s=$pdo->prepare('INSERT INTO admin_users(email,password_hash) VALUES(:email,:hash)');
        $s->execute(['email'=>$email,'hash'=>password_hash($password,PASSWORD_DEFAULT)]);
        header('Location: login.php?setup=1'); exit;
    }
}
admin_header('Configuration'); ?>
<section class="auth-card"><span class="kicker">PREMIÈRE CONFIGURATION</span><h1>Créer l’administrateur</h1><p>Cette étape n’est disponible qu’une seule fois.</p><?php if($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>E-mail<input type="email" name="email" required></label><label>Mot de passe sécurisé<input type="password" name="password" minlength="12" required></label><button class="admin-button">Créer le compte</button></form></section><?php admin_footer(); ?>
