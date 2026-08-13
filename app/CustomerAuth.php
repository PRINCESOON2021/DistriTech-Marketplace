<?php
declare(strict_types=1);
final class CustomerAuth
{
    public static function loggedIn(): bool { return !empty($_SESSION['customer_id']); }
    public static function id(): ?int { return self::loggedIn() ? (int) $_SESSION['customer_id'] : null; }
    public static function login(string $email, string $password): bool
    {
        $pdo = Database::connection(); if (!$pdo) return false;
        $s = $pdo->prepare('SELECT id,password_hash FROM customer_users WHERE email=:email AND active=1 LIMIT 1');
        $s->execute(['email'=>mb_strtolower(trim($email))]); $customer=$s->fetch();
        if(!$customer || !password_verify($password,$customer['password_hash'])) return false;
        session_regenerate_id(true); $_SESSION['customer_id']=(int)$customer['id']; return true;
    }
    public static function logout(): void { unset($_SESSION['customer_id']); session_regenerate_id(true); }
}
