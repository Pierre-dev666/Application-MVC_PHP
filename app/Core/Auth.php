<?php
namespace App\Core;

/**
 * Gestion de l'authentification via session.
 */
class Auth
{
    /** Démarre la session si nécessaire. */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @param array{id:int,first_name:string,last_name:string,email?:string,role?:string} $user
     */
    public static function login(array $user): void
    {
        self::start();
        $_SESSION['user'] = $user;
    }

    /** Déconnexion. */
    public static function logout(): void
    {
        self::start();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie((string) session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }

    /**
     * @return array{id:int,first_name:string,last_name:string,email?:string,role?:string}|null
     */
    public static function user(): ?array
    {
        self::start();
        /** @var array{id:int,first_name:string,last_name:string,email?:string,role?:string}|null $u */
        $u = $_SESSION['user'] ?? null;
        return $u; // <-- important : return explicite
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function isAdmin(): bool
    {
        $u = self::user();
        return $u !== null && ($u['role'] ?? null) === 'admin';
    }
}
?>