<?php
namespace App\Controllers;

use App\Core\View;

class UserController
{
    public function show(int $id): string
    {
        // Ici tu irais chercher l’utilisateur (DB). Démo statique :
        $user = [
            'id' => $id,
            'name' => 'Utilisateur ' . $id,
        ];

        return View::render('users-show', [
            'title' => 'Fiche utilisateur',
            'user'  => $user,
        ]);
    }
}
?>