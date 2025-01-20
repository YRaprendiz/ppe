<?php
function renderNavbar() {
    session_start();
    $userRole = $_SESSION['user']['roles'] ?? null; // Rôle de l'utilisateur ou null si non connecté
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="./Accueil.php">PPE Hôtel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./Accueil.php">Accueil</a>
                        </li>
                        
                        <!-- Si l'utilisateur est connecté -->
                        <?php if (isset($_SESSION['user'])): ?>
                            <li class="nav-item">
                                <span class="nav-link text-white">Bienvenue User<?php (isset($_SESSION['user']['prenom']))?></span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./Profil.php">Profil</a>
                            </li>
                            
                            <!-- Si l'utilisateur est admin -->
                            <?php if ($userRole === 'admin'): ?>
                                <li class="nav-item">
                                <span class="nav-link text-white">Bienvenue admin <?php (isset($_SESSION['user']['prenom']))?></span>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="VueAdminDashboard.php">Administration</a>
                                </li>
                            <?php endif; ?>
                            
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="./Logout.php">Déconnexion</a>
                            </li>
                        <?php else: ?>
                            <!-- Si l'utilisateur n'est pas connecté -->
                            <li class="nav-item">
                                <a class="nav-link" href="./Login.php">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./Inscription.php">Inscription</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    <?php
}
renderNavbar();

function renderFooter() {
    ?>
        <footer class="bg-light text-center text-lg-start mt-5">
            <div class="container p-4">
                <p class="text-center">&copy; 2025 PPE Hôtel. Tous droits réservés.</p>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}
?>
