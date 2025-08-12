<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

/**
 * Accès aux utilisateurs.
 */
class UserRepository
{
    /**
     * Retourne un utilisateur par email.
     * @param string $email
     * @return array{id:int,prenom:string,nom:string,email:string,password_hash:string,role:string}|null
     */
    public function findByEmail(string $email): ?array
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare(
            'SELECT id, prenom, nom, email, password_hash, role
             FROM users
             WHERE email = ?
             LIMIT 1'
        );
        $st->execute([$email]);
        /** @var array{id:int,prenom:string,nom:string,email:string,password_hash:string,role:string}|false $row */
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}