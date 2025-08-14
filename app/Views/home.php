<?php
// Normalise l'utilisateur courant depuis la session, peu importe la clé utilisée
$sessionUser =
  ($_SESSION['user'] ?? null)
  ?? ($_SESSION['auth'] ?? null)
  ?? ($_SESSION['logged_user'] ?? null);

// Si c’est un objet, on le transforme en array
if (is_object($sessionUser)) {
  $sessionUser = get_object_vars($sessionUser);
}

// Essaie aussi les IDs stockés séparément
$currentUserId =
  ($sessionUser['id'] ?? null)
  ?: ($_SESSION['user_id'] ?? null)
  ?: ($_SESSION['auth_id'] ?? null);
?>
<h1><?= htmlspecialchars($title ?? 'Trajets disponibles') ?></h1>

<?php if (empty($trips)): ?>
  <p>Aucun trajet disponible pour le moment.</p>
<?php else: ?>
  <ul class="trip-list">
    <?php foreach ($trips as $t): ?>
      <?php
      $tripId = (int)$t['id'];
      $isAuthor = $currentUserId && $currentUserId === (int)($t['author_user_id'] ?? 0);
      ?>
      <li class="trip-item">
        <div><strong>Départ :</strong> <?= htmlspecialchars($t['from_agency']) ?> — <?= date('d/m/Y H:i', strtotime($t['departure_at'])) ?></div>
        <div><strong>Arrivée :</strong> <?= htmlspecialchars($t['to_agency']) ?><?= $t['arrival_at'] ? ' — ' . date('d/m/Y H:i', strtotime($t['arrival_at'])) : '' ?></div>
        <div><strong>Places disponibles :</strong> <?= (int)$t['places_available'] ?></div>

        <?php if ($currentUserId): ?>
          <div class="actions">
            <button class="btn" data-modal-open="trip-modal-<?= $tripId ?>">Détails du conducteur</button>

            <?php if ($isAuthor): ?>
              <a class="btn secondary" href="/trips/<?= $tripId ?>/edit">Modifier</a>
              <form method="POST" action="/trips/<?= $tripId ?>/delete" style="display:inline" onsubmit="return confirm('Supprimer ce trajet ?');">
                <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf'] ?? '') ?>">
                <button class="btn danger" type="submit">Supprimer</button>
              </form>
            <?php endif; ?>
          </div>

          <!-- Modal -->
          <div class="modal" id="trip-modal-<?= $tripId ?>" aria-hidden="true">
            <div class="modal-backdrop" data-modal-close="trip-modal-<?= $tripId ?>"></div>
            <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="modal-title-<?= $tripId ?>">
              <h3 id="modal-title-<?= $tripId ?>">Conducteur</h3>
              <p><strong>Nom :</strong> <?= htmlspecialchars(($t['author_firstname'] ?? '') . ' ' . ($t['author_lastname'] ?? '')) ?></p>
              <p><strong>Téléphone :</strong> <?= htmlspecialchars($t['author_phone'] ?? '—') ?></p>
              <p><strong>Email :</strong> <?= htmlspecialchars($t['author_email'] ?? '—') ?></p>
              <p><strong>Places disponibles :</strong> <?= (int)$t['places_available'] ?></p>
              <div class="modal-actions">
                <button class="btn" data-modal-close="trip-modal-<?= $tripId ?>">Fermer</button>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>

  <nav class="pagination">
    <a class="btn <?= $page <= 1 ? 'disabled' : '' ?>" href="<?= $page <= 1 ? '#' : '?page=' . ($page - 1) ?>">Précédent</a>
    <?php for ($p = 1; $p <= $pages; $p++): ?>
      <a class="btn <?= $p === $page ? 'active' : '' ?>" href="?page=<?= $p ?>"><?= $p ?></a>
    <?php endfor; ?>
    <a class="btn <?= $page >= $pages ? 'disabled' : '' ?>" href="<?= $page >= $pages ? '#' : '?page=' . ($page + 1) ?>">Suivant</a>
  </nav>
<?php endif; ?>

<script>
  document.addEventListener('click', function(e) {
    if (e.target.matches('[data-modal-open]')) {
      const id = e.target.getAttribute('data-modal-open');
      document.getElementById(id).setAttribute('aria-hidden', 'false');
    }
    if (e.target.matches('[data-modal-close]') || e.target.classList.contains('modal-backdrop')) {
      const id = e.target.getAttribute('data-modal-close') || e.target.closest('.modal').id;
      document.getElementById(id).setAttribute('aria-hidden', 'true');
    }
  });
</script>

<style>
  .trip-list {
    list-style: none;
    padding: 0;
    margin: 1rem 0;
    display: grid;
    gap: 12px;
  }

  .trip-item {
    border: 1px solid #e3e3e3;
    border-radius: 8px;
    padding: 12px;
  }

  .pagination {
    display: flex;
    gap: 8px;
    align-items: center;
    margin-top: 16px;
  }

  .btn {
    padding: 6px 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    text-decoration: none;
    background: #eee;
    cursor: pointer;
    color: #000;
  }

  .btn:hover {
    background: #ddd;
  }

  .btn.active {
    font-weight: bold;
    border-color: #333;
  }

  .btn.disabled {
    pointer-events: none;
    opacity: .5;
  }

  .btn.danger {
    background: #fdd;
    border-color: #f99;
  }

  .btn.secondary {
    background: #eef;
    border-color: #99f;
  }

  .modal[aria-hidden="true"] {
    display: none;
  }

  .modal {
    position: fixed;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999;
  }

  .modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, .5);
  }

  .modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    position: relative;
    z-index: 1000;
    max-width: 400px;
    width: 100%;
  }
</style>