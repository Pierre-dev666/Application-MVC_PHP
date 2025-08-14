<?php /** @var list<array{id:int,name:string,city:string}> $agencies */ ?>
<section class="container py-4" style="max-width:720px;">
  <h1 class="h3 mb-3"><?= htmlspecialchars($title ?? 'Créer un trajet') ?></h1>

  <form method="post" action="/admin/trips">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf ?? '') ?>">

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Agence de départ</label>
        <select name="origin_agency_id" class="form-select" required>
          <option value="" selected disabled>Choisir...</option>
          <?php foreach ($agencies as $a): ?>
            <option value="<?= (int)$a['id'] ?>">
              <?= htmlspecialchars($a['city']) ?> — <?= htmlspecialchars($a['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Agence d'arrivée</label>
        <select name="destination_agency_id" class="form-select" required>
          <option value="" selected disabled>Choisir...</option>
          <?php foreach ($agencies as $a): ?>
            <option value="<?= (int)$a['id'] ?>">
              <?= htmlspecialchars($a['city']) ?> — <?= htmlspecialchars($a['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Date/heure départ</label>
        <input type="datetime-local" name="departure_at" class="form-control" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Date/heure arrivée</label>
        <input type="datetime-local" name="arrival_at" class="form-control" required>
      </div>

      <div class="col-12">
        <label class="form-label">Places disponibles</label>
        <input type="number" min="1" name="places_available" class="form-control" required>
      </div>

      <div class="col-12 d-flex gap-2">
        <button class="btn btn-primary">Enregistrer</button>
        <a class="btn btn-outline-secondary" href="/admin/trips">Annuler</a>
      </div>
    </div>
  </form>
</section>