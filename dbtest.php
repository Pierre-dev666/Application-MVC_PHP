<?php
$c = require __DIR__ . '/app/config.php';
try {
  new PDO($c['db']['dsn'], $c['db']['user'], $c['db']['pass'], $c['db']['options']);
  echo "Connexion OK\n";
} catch (Throwable $e) {
  echo "Erreur : " . $e->getMessage() . "\n";
}