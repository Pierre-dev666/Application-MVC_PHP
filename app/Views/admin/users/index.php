<?php

/** @var string $title */
/** @var array<int, array{id:int,prenom:string,nom:string,telephone:string,email:string,role:string,created_at:string}> $users */
?>
<section class="container py-4">
    <h1 class="h3 mb-3"><?= htmlspecialchars($title) ?></h1>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Créé le</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= (int)$u['id'] ?></td>
                        <td><?= htmlspecialchars($u['prenom']) ?></td>
                        <td><?= htmlspecialchars($u['nom']) ?></td>
                        <td><?= htmlspecialchars($u['telephone']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><span class="badge bg-<?= $u['role'] === 'admin' ? 'dark' : 'secondary' ?>"><?= htmlspecialchars($u['role']) ?></span></td>
                        <td><?= htmlspecialchars($u['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>