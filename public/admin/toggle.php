<?php
require __DIR__ . '/bootstrap.php'; AdminAuth::requireLogin();
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit;} verify_csrf();
$s=admin_db()->prepare('UPDATE products SET active = NOT active WHERE id=:id'); $s->execute(['id'=>(int)($_POST['id']??0)]); header('Location: index.php');
