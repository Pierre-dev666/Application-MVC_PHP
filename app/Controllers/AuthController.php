<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Auth;
use App\Repositories\UserRepository;

/**
 * Contrôleur d'authentification.
 */
class AuthController
{
    /** Affiche le formulaire de connexion. */
    public function showLogin(): string
    {
        \App\Core\Auth::start();
        $_SESSION['csrf'] = bin2hex(random_bytes(16));

        return View::render('auth/login', [
            'title' => 'Connexion',
            'csrf'  => $_SESSION['csrf'],
            'error' => $_GET['e'] ?? null,
        ]);
    }

    /** Traite la connexion. */
    public function login(): void
    {
        Auth::start();

        // CSRF
        $csrf = $_POST['csrf'] ?? '';
        if (!isset($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $csrf)) {
            header('Location: /login?e=csrf');
            exit;
        }

        $email    = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            header('Location: /login?e=empty');
            exit;
        }

        $repo = new UserRepository();
        $user = $repo->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            header('Location: /login?e=creds');
            exit;
        }

        // Connexion OK — on stocke les clés comme dans la BDD (prenom/nom/telephone)
        Auth::login([
            'id'         => (int) $user['id'],
            'first_name' => $user['prenom'],
            'last_name'  => $user['nom'],
            'email'      => $user['email'],
            'role'       => $user['role'],
        ]);

        header('Location: ' . ($user['role'] === 'admin' ? '/admin' : '/'));
        exit;
    }

    /** Déconnexion. */
    public function logout(): void
    {
        Auth::logout();
        header('Location: /');
        exit;
    }
}
