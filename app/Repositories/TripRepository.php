<?php

namespace App\Repositories;

use PDO;

class TripRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = \App\Core\DB::pdo();
        $this->pdo->exec("SET NAMES utf8mb4");
    }

    public function upcomingWithAvailability(int $limit = 20, int $offset = 0): array
    {
        $sql = "
            SELECT
                t.id,
                t.departure_at,
                t.arrival_at,
                t.places_available,
                t.author_user_id,
                af.name AS from_agency,
                at.name AS to_agency,
                u.prenom  AS author_firstname,
                u.nom     AS author_lastname,
                u.telephone AS author_phone,
                u.email     AS author_email
            FROM trips t
            JOIN agencies af ON af.id = t.origin_agency_id
            JOIN agencies at ON at.id = t.destination_agency_id
            LEFT JOIN users u ON u.id = t.author_user_id
            WHERE t.departure_at >= NOW()
              AND t.places_available > 0
            ORDER BY t.departure_at ASC
            LIMIT :limit OFFSET :offset
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUpcomingWithAvailability(): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM trips t
            WHERE t.departure_at >= NOW()
              AND t.places_available > 0
        ";
        return (int)$this->pdo->query($sql)->fetchColumn();
    }
    public function allWithAgencies(): array
    {
        $sql = "
        SELECT
            t.id,
            t.departure_at,
            t.arrival_at,
            t.places_available,
            af.name AS from_agency,
            at.name AS to_agency,
            u.id AS author_id,
            u.first_name AS author_first_name,
            u.last_name AS author_last_name
        FROM trips t
        JOIN agencies af ON af.id = t.origin_agency_id
        JOIN agencies at ON at.id = t.destination_agency_id
        LEFT JOIN users u ON u.id = t.author_user_id
        ORDER BY t.departure_at ASC
    ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /** Récupérer un trajet par id */
    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                  t.*,
                af.name AS from_agency,
                af.id   AS from_agency_id,
                at.name AS to_agency,
                at.id   AS to_agency_id
                FROM trips t
                JOIN agencies af ON af.id = t.origin_agency_id
                JOIN agencies at ON at.id = t.destination_agency_id
                WHERE t.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /** Suppression d’un trajet */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM trips WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
    public function update(int $id, array $data): bool
    {
        $sql = "
        UPDATE trips
        SET origin_agency_id = :origin_agency_id,
            destination_agency_id = :destination_agency_id,
            departure_at = :departure_at,
            arrival_at = :arrival_at,
            places_available = :places_available
        WHERE id = :id
    ";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':origin_agency_id'      => $data['origin_agency_id'],
            ':destination_agency_id' => $data['destination_agency_id'],
            ':departure_at'          => $data['departure_at'] ?? null, // ✅
            ':arrival_at'            => $data['arrival_at']   ?? null, // ✅
            ':places_available'      => $data['places_available'],
            ':id'                    => $id,
        ]);
    }
}
