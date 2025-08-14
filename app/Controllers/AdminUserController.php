<?php

namespace App\Controllers;

use App\Core\View;
use App\Repositories\UserRepository;

/** Listing des utilisateurs (lecture seule) */
class AdminUserController
{
    public function index(): string
    {
        $users = (new UserRepository())->all();
        return View::render('admin/users/index', [
            'title' => 'Utilisateurs',
            'users' => $users,
        ]);
    }
}
