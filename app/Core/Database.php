<?php
namespace App\Core;

use PDO;
use PDOException;

/**
 * Gestionnaire d'accès PDO (singleton).
 */
class Database
{
    /** @var PDO|null */
    private static ?PDO $pdo = null;

    /**
     * Retourne une instance PDO connectée à MySQL.
     */
    public static function pdo(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        /** @var array{db: array{dsn:string,user:string,pass:string,options:array}} $cfg */
        $cfg = require __DIR__ . '/../config.php';
        $d = $cfg['db'];

        try {
            self::$pdo = new PDO($d['dsn'], $d['user'], $d['pass'], $d['options']);
        } catch (PDOException $e) {
            throw $e; // en prod → loguer avant
        }

        return self::$pdo;
    }
}