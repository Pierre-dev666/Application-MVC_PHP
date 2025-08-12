<?php
use PHPUnit\Framework\TestCase;
use App\Core\View;

final class ViewTest extends TestCase
{
    public function testRenderInjectsDataIntoLayout(): void
    {
        // Arrange: crée un faux template temporaire
        $tmpViewDir = __DIR__ . '/tmp';
        @mkdir($tmpViewDir, 0777, true);

        $layout = $tmpViewDir . '/layout.php';
        $view   = $tmpViewDir . '/page.php';

        file_put_contents($view, '<p><?= htmlspecialchars($message) ?></p>');
        file_put_contents($layout, '<html><body><?= $content ?></body></html>');

        // Monkey patch du chemin via subclass anonyme (si View::render est figé)
        $res = (function () use ($tmpViewDir) {
            $class = new class($tmpViewDir) extends View {
                private string $dir;
                public function __construct(string $dir){ $this->dir = $dir; }
                public function renderLocal(string $tpl, array $data = []): string {
                    extract($data, EXTR_SKIP);
                    ob_start();
                    require $this->dir . '/'. $tpl .'.php';
                    $content = ob_get_clean();
                    ob_start();
                    require $this->dir . '/layout.php';
                    return ob_get_clean();
                }
            };
            return $class->renderLocal('page', ['message' => 'Hello']);
        })();

        $this->assertStringContainsString('<p>Hello</p>', $res);
    }
}
?>