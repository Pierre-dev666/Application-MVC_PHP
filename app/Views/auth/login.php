<?php
/** @var string $title */
/** @var string $csrf */
/** @var string|null $error */
?>
<section class="container py-4" style="max-width:520px;">
  <h1 class="h3 mb-4"><?= htmlspecialchars($title) ?></h1>

  <?php if ($error): ?>
    <?php
      $msg = [
        'csrf'  => 'Session expirée. Réessayez.',
        'empty' => 'Veuillez renseigner email et mot de passe.',
        'creds' => 'Identifiants incorrects.',
      ][$error] ?? 'Erreur de connexion.';
    ?>
    <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <form method="post" action="/login" class="row gy-3">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">

    <div class="col-12">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" name="email" required autocomplete="username">
    </div>

    <div class="col-12">
      <label class="form-label">Mot de passe</label>
      <input type="password" class="form-control" name="password" required autocomplete="current-password">
    </div>

    <div class="col-12">
      <button class="btn btn-primary w-100" type="submit">Se connecter</button>
    </div>
  </form>
</section>