<?php
require __DIR__ . '/bootstrap.php';
$pdo=admin_db();
if (!admin_installed($pdo)) { header('Location: setup.php'); exit; }
if (AdminAuth::loggedIn()) { header('Location: index.php'); exit; }
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') { verify_csrf(); if(AdminAuth::login((string)($_POST['email']??''),(string)($_POST['password']??''))){header('Location: index.php');exit;} $error='Identifiants incorrects.'; }
admin_header('Connexion'); ?>
<section class="auth-card"><span class="kicker">ESPACE SÉCURISÉ</span><h1>Administration</h1><?php if(isset($_GET['setup'])): ?><div class="alert success">Compte créé. Connectez-vous.</div><?php endif; ?><?php if($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>E-mail<input type="email" name="email" required autofocus></label><label>Mot de passe<input type="password" name="password" required></label><button class="admin-button">Se connecter</button></form></section><?php admin_footer(); ?>
