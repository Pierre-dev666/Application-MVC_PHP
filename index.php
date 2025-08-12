<?php
require __DIR__ . '/vendor/autoload.php';

use Klein\Klein;
use Klein\Request;
use Klein\Response;

$router = new Klein();

// Middleware global (équivalent de app.use dans Express)
$router->respond(function (Request $request, Response $response) {
    $response->header('Content-Type', 'text/html; charset=utf-8');
});

// Route GET /
$router->respond('GET', '/', function () {
    return 'Hello World avec Klein';
});

// Route GET avec paramètre
$router->respond('GET', '/user/[i:id]', function (Request $request) {
    return "Utilisateur ID : " . $request->id;
});

// Route POST
$router->respond('POST', '/user', function (Request $request) {
    $name = $request->param('name', 'Inconnu');
    return "Création utilisateur : $name";
});

// 404
$router->onHttpError(function ($code, $router) {
    if ($code == 404) {
        echo "Erreur 404 -Page introuvable";
    }
});

$router->dispatch();