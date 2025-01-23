<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php?page=accueil">Hôtel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=accueil">Accueil</a>
                    </li>
                    <?php if (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=photosList">Galerie Photos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=chambresList">Nos Chambres</a>
                    </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav">
                    <?php if (!isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=connexion">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=inscription">Inscription</a>
                        </li>
                    <?php else: ?>
                        <?php if ($_SESSION['user']['User_role'] === 'Admin'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    Administration
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="index.php?page=utilisateurs">Utilisateurs</a></li>
                                    <li><a class="dropdown-item" href="index.php?page=photos">Gérer Photos</a></li>
                                    <li><a class="dropdown-item" href="index.php?page=chambres">Gérer Chambres</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Bonjour, <?php echo htmlspecialchars($_SESSION['user']['Prenom']); ?>
                                (<?php echo htmlspecialchars($_SESSION['user']['User_role']); ?>)
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="index.php?page=profil">Profil</a></li>
                                <?php if ($_SESSION['user']['User_role'] === 'Client'): ?>
                                    <li><a class="dropdown-item" href="index.php?page=reservations">Mes Réservations</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?page=deconnexion">Déconnexion</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>