<?php

namespace App\Controllers;

use App\Core\Guard;
use App\Core\View;
use App\Repositories\TripRepository;
use App\Repositories\AgencyRepository;
use Klein\Request;
use Klein\Response;

class TripController
{

    public function edit(Request $request, Response $response)
    {
        Guard::requireAuth();

        $id = (int) $request->param('id');
        $repo = new TripRepository();
        $trip = $repo->find($id);

        if (!$trip) {
            return $response->code(404)->body('Trajet introuvable');
        }

        $agencyRepo = new AgencyRepository();
        $agencies = $agencyRepo->all();

        return View::render('trips/edit', [
            'trip' => $trip,
            'agencies' => $agencies,
            'title' => 'Modifier le trajet'
        ]);
    }

    public function update(Request $request, Response $response)
    {
        Guard::requireAuth();

        $id = (int) $request->param('id');
        $origin = (int)($_POST['origin_agency_id'] ?? 0);
        $destination = (int)($_POST['destination_agency_id'] ?? 0);

        if ($origin === $destination) {
            $_SESSION['flash'] = "Les agences de départ et d'arrivée doivent être différentes.";
            return $response->redirect("/trips/{$id}/edit");
        }

        $repo = new TripRepository();
        $repo->update($id, [
            'origin_agency_id' => $origin,
            'destination_agency_id' => $destination,
            'departure_at' => $_POST['departure_at'] ?? null,
            // ✅ on passe aussi arrival_at (même si null)
            'arrival_at' => $_POST['arrival_at'] ?? null,
            'places_available' => (int)($_POST['places_available'] ?? 0)
        ]);

        $_SESSION['flash'] = 'Trajet modifié avec succès';
        return $response->redirect('/');
    }
    public function delete(Request $request, Response $response)
    {
        Guard::requireAuth();

        $id = (int) $request->param('id');

        $repo = new TripRepository();
        $trip = $repo->find($id);
        if (!$trip) {
            return $response->code(404)->body('Trajet introuvable');
        }

        if (!isset($_SESSION['user']['id']) || (int)$trip['author_user_id'] !== (int)$_SESSION['user']['id']) {
            return $response->code(403)->body('Accès interdit');
        }

        $repo->delete($id);

        $_SESSION['flash'] = 'Trajet supprimé';
        return $response->redirect('/');
    }
}
