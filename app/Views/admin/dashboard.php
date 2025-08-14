<?php /** @var string $title */ ?>
<section class="container py-4">
  <h1 class="h3 mb-4"><?= htmlspecialchars($title) ?></h1>
  <div class="list-group">
    <a href="/admin/users" class="list-group-item list-group-item-action">Utilisateurs</a>
    <a href="/admin/agencies" class="list-group-item list-group-item-action">Agences</a>
    <a href="/admin/trips" class="list-group-item list-group-item-action">Trajets</a>
  </div>
</section>