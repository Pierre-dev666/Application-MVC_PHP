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
     * Retourne tous les utilisateurs.
     * @return array<int, array{id:int,prenom:string,nom:string,telephone:string,email:string,role:string,created_at:string}>
     */
    public function all(): array
    {
        $pdo = Database::pdo();
        $sql = 'SELECT id, prenom, nom, telephone, email, role, created_at
                FROM users ORDER BY created_at DESC';
        return (array)$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne un utilisateur par email (pour login).
     * @param string $email
     * @return array{id:int,prenom:string,nom:string,telephone:string,email:string,password_hash:string,role:string}|null
     */
    public function findByEmail(string $email): ?array
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare(
            'SELECT id, prenom, nom, telephone, email, password_hash, role
             FROM users WHERE email = ? LIMIT 1'
        );
        $st->execute([$email]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        /** @var array{id:int,prenom:string,nom:string,telephone:string,email:string,password_hash:string,role:string}|false $row */
        return $row ?: null;
    }
}
?>