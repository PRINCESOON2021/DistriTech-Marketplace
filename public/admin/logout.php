<?php
require __DIR__ . '/bootstrap.php';
AdminAuth::logout();
header('Location: login.php');
