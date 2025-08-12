<?php

/**
 * Header de l'application
 *
 * Affiche un menu dynamique en fonction du rôle de l'utilisateur.
 *
 * @var array|null $user  Données de l'utilisateur connecté
 * @var string|null $role Rôle de l'utilisateur ("admin", "user", null)
 */
?>
<header>
    <?php
    /**
     * Header (navbar) — rendu dynamique selon le rôle
     *
     * Variables attendues (définies dans layout.php) :
     * @var array{id:int,first_name:string,last_name:string,role?:string}|null $user
     * @var string|null $role
     */
    ?>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= $role === 'admin' ? '/admin' : '/' ?>">TOUCHE PAS AU KLAXON</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="topnav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">

                    <?php if (!$user): ?>
                        <!-- Visiteur -->
                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="/login">Connexion</a>
                        </li>

                    <?php elseif ($role === 'admin'): ?>
                        <!-- Admin -->
                        <li class="nav-item"><a class="nav-link" href="/admin/users">Utilisateurs</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/projects">Projets</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/reports">Rapports</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/settings">Paramètres</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/logs">Logs</a></li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-danger" href="/logout">Déconnexion</a>
                        </li>

                    <?php else: ?>
                        <!-- Utilisateur -->
                        <li class="nav-item">
                            <a class="btn btn-primary" href="/projects/create">Créer un projet</a>
                        </li>
                        <li class="nav-item">
                            <span class="navbar-text text-white">
                                <?= htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="/logout">Déconnexion</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
</header>