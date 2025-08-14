<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

/**
 * Accès aux trajets.
 */
class TripRepository
{
    /**
     * Liste des trajets avec libellés d’agences.
     * @return array<int, array{
     *   id:int, departure_at:string, places_available:int, created_at:string,
     *   origin_id:int, origin_name:string, origin_city:string,
     *   dest_id:int, dest_name:string, dest_city:string
     * }>
     */
    public function allWithAgencies(): array
    {
        $pdo = Database::pdo();
        $sql = 'SELECT t.id, t.departure_at, t.places_available, t.created_at,
                       o.id  AS origin_id, o.name AS origin_name, o.city AS origin_city,
                       d.id  AS dest_id,  d.name AS dest_name,  d.city AS dest_city
                FROM trips t
                JOIN agencies o ON o.id = t.origin_agency_id
                JOIN agencies d ON d.id = t.destination_agency_id
                ORDER BY t.departure_at DESC, t.id DESC';
        return (array)$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): void
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare('DELETE FROM trips WHERE id = ?');
        $st->execute([$id]);
    }
}
?>