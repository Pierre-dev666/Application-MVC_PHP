<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

/**
 * Accès aux agences.
 */
class AgencyRepository
{
    /**
     * Liste des agences.
     * @return array<int, array{id:int,name:string,city:string,created_at:string}>
     */
    public function all(): array
    {
        $pdo = Database::pdo();
        $sql = 'SELECT id, name, city, created_at FROM agencies ORDER BY city, name';
        return (array)$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** @return array{id:int,name:string,city:string,created_at:string}|null */
    public function find(int $id): ?array
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare('SELECT id, name, city, created_at FROM agencies WHERE id = ?');
        $st->execute([$id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        /** @var array{id:int,name:string,city:string,created_at:string}|false $row */
        return $row ?: null;
    }

    public function create(string $name, string $city): int
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare('INSERT INTO agencies (name, city, created_at) VALUES (?, ?, NOW())');
        $st->execute([$name, $city]);
        return (int)$pdo->lastInsertId();
    }

    public function update(int $id, string $name, string $city): void
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare('UPDATE agencies SET name = ?, city = ? WHERE id = ?');
        $st->execute([$name, $city, $id]);
    }

    public function delete(int $id): void
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare('DELETE FROM agencies WHERE id = ?');
        $st->execute([$id]);
    }

    /** Nombre de trajets liés à une agence (en origine ou destination) */
    public function tripsCount(int $agencyId): int
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare(
            'SELECT COUNT(*) FROM trips
             WHERE origin_agency_id = ? OR destination_agency_id = ?'
        );
        $st->execute([$agencyId, $agencyId]);
        return (int)$st->fetchColumn();
    }
}
