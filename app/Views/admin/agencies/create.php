<?php

/** @var string $title */ /** @var string $csrf */ ?>
<section class="container py-4" style="max-width:560px;">
    <h1 class="h3 mb-4"><?= htmlspecialchars($title) ?></h1>
    <form method="post" action="/admin/agencies" class="row g-3">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
        <div class="col-12">
            <label class="form-label">Nom de l'agence</label>
            <input class="form-control" name="name" required>
        </div>
        <div class="col-12">
            <label class="form-label">Ville</label>
            <input class="form-control" name="city" required>
        </div>
        <div class="col-12">
            <button class="btn btn-primary">Créer</button>
            <a class="btn btn-outline-secondary" href="/admin/agencies">Annuler</a>
        </div>
    </form>
</section>