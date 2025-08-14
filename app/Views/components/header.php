<?php

/**
 * Header de l'application (Bootstrap)
 *
 * Affiche un menu dynamique en fonction du rôle de l'utilisateur.
 *
 * Variables fournies par layout.php :
 * @var array{id:int,prenom:string,nom:string,email?:string,role?:string}|null $user
 * @var string|null $role  'admin' | 'user' | null
 */
?>
<header>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="<?= ($role === 'admin') ? '/admin' : '/' ?>">
        TOUCHE PAS AU KLAXON
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav" aria-controls="topnav" aria-expanded="false" aria-label="Toggle navigation">
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
            <!-- Administrateur -->
            <li class="nav-item"><a class="nav-link" href="/admin/users">Utilisateurs</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/agencies">Agences</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/trips">Trajets</a></li>
            <li class="nav-item ms-2">
              <a class="btn btn-danger btn-sm" href="/logout">Déconnexion</a>
            </li>

          <?php else: ?>
            <!-- Utilisateur standard -->
            <li class="nav-item">
              <a class="btn btn-primary" href="/trips/create">Créer un trajet</a>
            </li>
            <li class="nav-item">
              <span class="navbar-text text-white">
                Bonjour <?= htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?>
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