<?php

use Klein\Klein;
use Klein\Request;
use Klein\Response;

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\AuthController;

use App\Controllers\AdminController;
use App\Controllers\AdminUserController;
use App\Controllers\AdminAgencyController;
use App\Controllers\Admin\TripController as AdminTripController; // 👈 le bon contrôleur

/** @var Klein $router */

// Middleware global
$router->respond(function (Request $req, Response $res) {
    $res->header('Content-Type', 'text/html; charset=utf-8');
});

// Routes publiques
$router->respond('GET', '/', function () {
    return (new HomeController())->index();
});

$router->respond('GET', '/user/[i:id]', function (Request $req) {
    return (new UserController())->show($req->id);
});

$auth = new AuthController();
$router->respond('GET',  '/login',  [$auth, 'showLogin']);
$router->respond('POST', '/login',  [$auth, 'login']);
$router->respond('GET',  '/logout', [$auth, 'logout']);

$router->respond('GET', '/projects/create', function () {
    \App\Core\Guard::requireAuth();
    return \App\Core\View::render('projects/create', ['title' => 'Créer un projet']);
});

// 404/405
$router->onHttpError(function ($code) {
    if ($code === 404) {
        http_response_code(404);
        echo '<h1>404 - Page introuvable</h1>';
    } elseif ($code === 405) {
        http_response_code(405);
        echo '<h1>405 - Méthode non autorisée</h1>';
    }
});

// Zone admin
$router->with('/admin', function ($r) {

    // Garde globale admin
    $r->respond('*', function () {
        \App\Core\Guard::requireAdmin();
    });

    $r->respond('GET',  '/',        [new AdminController(),     'dashboard']);
    $r->respond('GET',  '/users',   [new AdminUserController(), 'index']);

    // Agencies CRUD
    $agency = new AdminAgencyController();
    $r->respond('GET',  '/agencies',               [$agency, 'index']);
    $r->respond('GET',  '/agencies/create',        [$agency, 'createForm']);
    $r->respond('POST', '/agencies',               [$agency, 'store']);
    $r->respond('GET',  '/agencies/[i:id]/edit',   [$agency, 'editForm']);
    $r->respond('POST', '/agencies/[i:id]',        [$agency, 'update']);
    $r->respond('POST', '/agencies/[i:id]/delete', [$agency, 'delete']);

    // Trips (liste + suppression)
    $trip = new AdminTripController();
    $r->respond('GET',  '/trips',                   [$trip, 'index']);     // à implémenter si besoin
    $r->respond('GET',  '/trips/[i:id]/delete',     [$trip, 'destroy']);   // ou POST si tu préfères
    // Si tu veux faire la suppression en POST (recommandé) :
    // $r->respond('POST', '/trips/[i:id]/delete',   [$trip, 'destroy']);
});
?>