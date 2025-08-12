<?php
/**
 * Layout principal
 *
 * @var string $title
 * @var string $content
 */

use App\Core\Auth;

Auth::start();
$user = Auth::user();                 // array{id:int,first_name:string,last_name:string,role?:string}|null
$role = $user['role'] ?? null;        // 'admin' | 'user' | null
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title) ?></title>

  <!-- CSS -->
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<?php require __DIR__ . '/components/header.php'; ?>

<main class="container py-4">
  <?= (string) $content ?>
</main>

<!-- JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>