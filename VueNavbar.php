<?php
function renderNavbar() {
    echo '<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PPE_Hotel</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Hôtel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php?page=chambres">Chambres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=chambres">|</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=services">|</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=contact">|</a>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=login">Connexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>';
}

function renderFooter() {
    echo '<footer class="bg-light text-center text-lg-start">
        <div class="container p-4">
            <p class="text-center">&copy; 2024 Hôtel PPE. Tous droits réservés.</p>
        </div>
    </footer>
    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>';
}
?>
