<?php

namespace App\Controllers\Admin;

use App\Core\Database;
use Klein\Request;
use Klein\Response;

class TripController
{
    public function index(Request $request, Response $response, ...$rest): string
    {
        $pdo = Database::pdo();
        $rows = $pdo->query(
            'SELECT t.id, t.places_available, t.departure_at,
                    ao.city AS origin_city, ad.city AS dest_city
             FROM trips t
             JOIN agencies ao ON ao.id = t.origin_agency_id
             JOIN agencies ad ON ad.id = t.destination_agency_id
             ORDER BY t.departure_at DESC'
        )->fetchAll();

        return \App\Core\View::render('admin/trips/index', [
            'title' => 'Trajets',
            'trips' => $rows,
        ]);
    }

    public function destroy(Request $request, Response $response, ...$rest)
    {
        $id = (int) $request->param('id');
        $pdo = Database::pdo();
        $stmt = $pdo->prepare('DELETE FROM trips WHERE id = ?');
        $stmt->execute([$id]);

        $_SESSION['flash'] = 'Trajet supprimé avec succès';
        return $response->redirect('/admin/trips');
    }
}
