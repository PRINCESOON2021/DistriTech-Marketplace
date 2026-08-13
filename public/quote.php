<?php

declare(strict_types=1);
require dirname(__DIR__) . '/app/security.php';
secure_session_start();
require dirname(__DIR__) . '/app/Database.php';
require dirname(__DIR__) . '/app/ProductRepository.php';
require dirname(__DIR__) . '/app/helpers.php';

$repository = new ProductRepository();
$selectedProduct = isset($_GET['product']) ? $repository->find((int) $_GET['product']) : null;
$success = false;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim((string) ($_POST['name'] ?? ''));
    $company = trim((string) ($_POST['company'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $message = trim((string) ($_POST['message'] ?? ''));
    if (!verify_captcha('quote', (string) ($_POST['captcha'] ?? ''))) $errors[] = 'La réponse de sécurité est incorrecte.';
    if ($name === '') $errors[] = 'Le nom est obligatoire.';
    if ($company === '') $errors[] = 'La société est obligatoire.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'L’adresse e-mail est invalide.';
    if (!preg_match('/^[+0-9][0-9 .()-]{7,24}$/', $phone)) $errors[] = 'Le numéro de téléphone est obligatoire et doit être valide.';
    if ($errors === []) {
        $pdo = Database::connection();
        if ($pdo instanceof PDO) {
            $statement = $pdo->prepare('INSERT INTO quote_requests (name, company, email, phone, message, cart_json, status) VALUES (:name, :company, :email, :phone, :message, :cart, "new")');
            $statement->execute(['name'=>$name,'company'=>$company,'email'=>$email,'phone'=>$phone,'message'=>$message,'cart'=>json_encode($_SESSION['cart'] ?? [], JSON_UNESCAPED_UNICODE)]);
        }
        $_SESSION['cart'] = [];
        $success = true;
    }
}
$pageTitle = 'Demander un devis';
require __DIR__ . '/partials/header.php';
?>
<section class="quote-page"><div class="quote-intro"><span class="eyebrow">DEVIS PROFESSIONNEL</span><h1>Parlez-nous de votre besoin.</h1><p>Nous validons la solution, les licences, l’installation et le niveau de support avant de vous envoyer une proposition.</p><ul><li>Réponse personnalisée</li><li>Architecture adaptée à votre entreprise</li><li>Prix et disponibilité confirmés</li></ul></div>
<div class="quote-card"><?php if ($success): ?><div class="success-panel"><span>✓</span><h2>Demande enregistrée</h2><p>Votre demande de devis a bien été prise en compte.</p><a class="button primary" href="<?= e(url('index.php')) ?>">Retour à l’accueil</a></div><?php else: ?><h2>Demande de devis</h2><?php foreach ($errors as $error): ?><div class="notice error"><?= e($error) ?></div><?php endforeach; ?><form method="post" class="quote-form"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><div class="two-cols"><label>Nom complet *<input name="name" required maxlength="120" value="<?= e($_POST['name'] ?? '') ?>"></label><label>Société *<input name="company" required maxlength="160" value="<?= e($_POST['company'] ?? '') ?>"></label></div><div class="two-cols"><label>E-mail professionnel *<input type="email" name="email" required maxlength="190" value="<?= e($_POST['email'] ?? '') ?>"></label><label>Téléphone *<input type="tel" name="phone" required maxlength="30" value="<?= e($_POST['phone'] ?? '') ?>"></label></div><label>Votre besoin<textarea name="message" rows="6" maxlength="3000" placeholder="Produits, nombre d’utilisateurs, sites, installation, support..."><?= e($_POST['message'] ?? ($selectedProduct ? 'Je souhaite un devis pour ' . $selectedProduct['name'] . '.' : '')) ?></textarea></label><label class="captcha-field"><span>Vérification : combien font <b><?= e(captcha_question('quote')) ?></b> ?</span><input type="number" name="captcha" required autocomplete="off" aria-label="Réponse au CAPTCHA"></label><?php if (!empty($_SESSION['cart'])): ?><div class="notice">Votre panier (<?= cart_count() ?> article<?= cart_count() > 1 ? 's' : '' ?>) sera joint à la demande.</div><?php endif; ?><button class="button primary full" type="submit">Envoyer ma demande</button></form><?php endif; ?></div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
