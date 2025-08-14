<?php

namespace App\Controllers;

use App\Repositories\TripRepository;
use App\Core\View;

class HomeController
{
    public function index(): string
    {
        // On démarre la session si ce n'est pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        $repo  = new TripRepository();

        $limit  = 20;
        $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page - 1) * $limit;

        $trips = $repo->upcomingWithAvailability($limit, $offset);
        $total = $repo->countUpcomingWithAvailability();
        $pages = max(1, (int)ceil($total / $limit));

        return View::render('home', [
            'title'        => 'Trajets disponibles',
            'trips'        => $trips,
            'page'         => $page,
            'pages'        => $pages,
            'total'        => $total,
            'limit'        => $limit,
            'sessionUser'  => $_SESSION ?? [], // <-- on passe la session à la vue
        ]);
    }
}
