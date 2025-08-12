<?php
namespace App\Core;

/**
 * Rendu de vues avec layout.
 */
class View
{
    /**
     * @param string               $template ex: 'home'
     * @param array<string,mixed>  $data
     * @return string HTML final
     */
    public static function render(string $template, array $data = []): string
    {
        // Les variables seront visibles dans les vues
        extract($data, EXTR_SKIP);

        $viewPath   = __DIR__ . '/../Views/' . $template . '.php';
        $layoutPath = __DIR__ . '/../Views/layout.php';

        // 1) buffer de la vue pour produire $content
        ob_start();
        require $viewPath;
        $content = (string) ob_get_clean(); // garantie string

        // 2) buffer du layout qui consomme $content (et $title, $user, $role…)
        ob_start();
        require $layoutPath;
        return (string) ob_get_clean();
    }
}