<?php

use Klein\Klein;
use Klein\Request;
use Klein\Response;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\AuthController;

/** @var Klein $router */

// Middleware global (headers, sessions, etc.)
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

$authController = new \App\Controllers\AuthController();
$router->respond('GET', '/login', [$authController, 'showLogin']);
$router->respond('POST', '/login', [$authController, 'login']);
$router->respond('GET', '/logout', [$authController, 'logout']);

$router->respond('GET', '/projects/create', function () {
    \App\Core\Guard::requireAuth();
    return \App\Core\View::render('projects/create', ['title' => 'Créer un projet']);
});

$router->respond('GET', '/admin', function () {
    \App\Core\Guard::requireAdmin();
    return \App\Core\View::render('admin/dashboard', ['title' => 'Dashboard']);
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
