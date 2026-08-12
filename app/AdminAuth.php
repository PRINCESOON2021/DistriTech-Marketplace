<?php
declare(strict_types=1);

final class AdminAuth
{
    public static function loggedIn(): bool { return !empty($_SESSION['admin_id']); }
    public static function requireLogin(): void
    {
        if (!self::loggedIn()) { header('Location: login.php'); exit; }
    }
    public static function login(string $email, string $password): bool
    {
        $pdo = Database::connection();
        if (!$pdo) return false;
        $s = $pdo->prepare('SELECT id, password_hash FROM admin_users WHERE email = :email AND active = 1 LIMIT 1');
        $s->execute(['email' => mb_strtolower(trim($email))]);
        $user = $s->fetch();
        if (!$user || !password_verify($password, $user['password_hash'])) return false;
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int) $user['id'];
        return true;
    }
    public static function logout(): void
    {
        unset($_SESSION['admin_id']);
        session_regenerate_id(true);
    }
}
