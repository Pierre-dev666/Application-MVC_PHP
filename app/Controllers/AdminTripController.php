<?php
namespace App\Controllers;

use App\Core\View;
use App\Repositories\TripRepository;

/** Listing + suppression simple des trajets */
class AdminTripController
{
    public function index(): string
    {
        $_SESSION['csrf'] = $_SESSION['csrf'] ?? bin2hex(random_bytes(16));
        $trips = (new TripRepository())->allWithAgencies();
        return View::render('admin/trips/index', [
            'title' => 'Trajets',
            'csrf'  => $_SESSION['csrf'],
            'trips' => $trips,
        ]);
    }

    public function delete(int $id): void
    {
        $csrf = $_POST['csrf'] ?? '';
        if (!isset($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $csrf)) {
            $_SESSION['flash'] = ['msg' => 'CSRF invalide', 'type' => 'danger'];
            header('Location: /admin/trips'); exit;
        }
        (new TripRepository())->delete($id);
        $_SESSION['flash'] = ['msg' => 'Trajet supprimé', 'type' => 'success'];
        header('Location: /admin/trips'); exit;
    }
}
?>