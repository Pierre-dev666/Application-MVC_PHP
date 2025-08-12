<?php
namespace App\Core;

/**
 * Validations simples et réutilisables.
 */
class Validator
{
    /**
     * @param string $email
     * @return bool
     */
    public static function email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
?>