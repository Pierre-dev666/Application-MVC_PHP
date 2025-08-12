<?php
namespace App\Controllers;

use App\Core\View;

class HomeController
{
    public function index(): string
    {
        return View::render('home', [
            'title'   => 'Accueil',
            'message' => 'Hello World avec Klein 🚀 (depuis /public)',
        ]);
    }
}