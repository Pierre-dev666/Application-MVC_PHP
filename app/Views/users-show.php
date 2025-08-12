<?php
/** @var string $title */
/** @var array{id:int,name:string}|null $user */
?>
<section>
  <h1><?= htmlspecialchars($title) ?></h1>

  <?php if (is_array($user)): ?>
    <ul>
      <li>ID : <?= htmlspecialchars((string) $user['id']) ?></li>
      <li>Nom : <?= htmlspecialchars($user['name']) ?></li>
    </ul>
  <?php else: ?>
    <p>Utilisateur introuvable.</p>
  <?php endif; ?>
</section>