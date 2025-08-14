<?php

/** @var array<int,array{id:int,places_available:int,departure_at:string,origin_city:string,dest_city:string}> $trips */
/** @var string $title */
?>
<section class="container py-4">
  <h1 class="h3 mb-3"><?= htmlspecialchars($title) ?></h1>

  <?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash']) ?></div>
    <?php unset($_SESSION['flash']); ?>
  <?php endif; ?>

  <?php if (!$trips): ?>
    <div class="alert alert-info">Aucun trajet pour le moment.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Origine</th>
            <th>Destination</th>
            <th>Départ</th>
            <th>Places</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($trips as $t): ?>
            <tr>
              <td><?= (int)$t['id'] ?></td>
              <td><?= htmlspecialchars($t['origin_city']) ?></td>
              <td><?= htmlspecialchars($t['dest_city']) ?></td>
              <td><?= htmlspecialchars($t['departure_at']) ?></td>
              <td><?= (int)$t['places_available'] ?></td>
              <td class="text-end">
                <!-- Version GET (simple pour tester) -->
                <a class="btn btn-sm btn-outline-danger"
                  href="/admin/trips/<?= (int)$t['id'] ?>/delete"
                  onclick="return confirm('Supprimer ce trajet ?');">
                  Supprimer
                </a>

                <!-- Version POST (recommandée en prod)
              <form action="/admin/trips/<?= (int)$t['id'] ?>/delete" method="post" class="d-inline"
                    onsubmit="return confirm('Supprimer ce trajet ?');">
                <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
              </form>
              -->
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</section>