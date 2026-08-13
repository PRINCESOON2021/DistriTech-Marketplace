<?php
declare(strict_types=1);
require dirname(__DIR__).'/app/security.php';secure_session_start();require dirname(__DIR__).'/app/CustomerAuth.php';CustomerAuth::logout();header('Location: index.php');exit;
