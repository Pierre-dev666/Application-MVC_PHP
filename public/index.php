<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '1');
require __DIR__ . '/../vendor/autoload.php';

use Klein\Klein;

$router = new Klein();

$router = new \Klein\Klein();
require __DIR__ . '/../routes/web.php';

$router->dispatch();
?>