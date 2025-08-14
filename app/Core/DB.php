<?php

namespace App\Core;

use PDO;
use PDOException;

class DB
{
    private static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            // Charger la config
            $config = require __DIR__ . '/../config.php';
            $db     = $config['db'];

            try {
                self::$pdo = new PDO(
                    $db['dsn'],
                    $db['user'],
                    $db['pass'],
                    $db['options']
                );
            } catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
