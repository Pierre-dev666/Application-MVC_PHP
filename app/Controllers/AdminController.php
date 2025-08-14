<?php

namespace App\Controllers;

use App\Core\View;

/** Page d’accueil admin (tableau de bord simple) */
class AdminController
{
    public function dashboard(): string
    {
        return View::render('admin/dashboard', ['title' => 'Dashboard']);
    }
}
