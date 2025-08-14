<?php

/** @var string $title */
/** @var array<int, array{id:int,name:string,city:string,created_at:string}> $agencies */
?>
<section class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 m-0"><?= htmlspecialchars($title) ?></h1>
        <a class="btn btn-primary" href="/admin/agencies/create">+ Créer une agence</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Ville</th>
                    <th>Créée le</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agencies as $a): ?>
                    <tr>
                        <td><?= (int)$a['id'] ?></td>
                        <td><?= htmlspecialchars($a['name']) ?></td>
                        <td><?= htmlspecialchars($a['city']) ?></td>
                        <td><?= htmlspecialchars($a['created_at']) ?></td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-secondary" href="/admin/agencies/<?= (int)$a['id'] ?>/edit">Modifier</a>
                            <form action="/admin/agencies/<?= (int)$a['id'] ?>/delete" method="post" class="d-inline"
                                onsubmit="return confirm('Supprimer cette agence ?');">
                                <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf'] ?? '') ?>">
                                <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>