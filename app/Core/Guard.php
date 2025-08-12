<?php
namespace App\Core;

class Guard
{
    public static function requireAuth(): void
    {
        Auth::start();
        if (!Auth::check()) {
            header('Location: /login'); exit;
        }
    }

    public static function requireAdmin(): void
    {
        Auth::start();
        if (!Auth::isAdmin()) {
            header('Location: /'); exit;
        }
    }
}
?>