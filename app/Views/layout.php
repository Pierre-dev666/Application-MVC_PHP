<?php

/**
 * Layout principal
 *
 * @var string
 * @var string 
 */

use App\Core\Auth;

Auth::start();
$user = Auth::user();
$role = $user['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title) ?></title>

  <!-- CSS -->
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/theme.css">
</head>

<body>
  <?php
  $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  ?>

  <body class="page-<?= trim(str_replace('/', '-', $currentPath), '-') ?>">
    <?php require __DIR__ . '/components/header.php'; ?>

    <main class="container py-4">
      <?php
      // flash
      if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];

        if (is_string($flash)) {
          $type = 'info';
          $msg  = $flash;
        } elseif (is_array($flash)) {
          $type = $flash['type'] ?? 'info';
          $msg  = $flash['msg']  ?? '';
        } else {
          $type = 'info';
          $msg  = '';
        }

        if ($msg !== '') {
          echo '<div class="alert alert-' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . '">'
            . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8')
            . '</div>';
        }

        unset($_SESSION['flash']);
      }
      ?>
      <?= (string) $content ?>
    </main>
    <?php require __DIR__ . '/components/footer.php'; ?>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>

  </body>

</html>