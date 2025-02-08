<?php
// Ensure this page is included through the main index.php
if (!defined('INCLUDED_FROM_INDEX')) {
    header('Location: /ppe/index.php?page=404');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée</title>
    <?php include 'Vue/header.php'; ?>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Page non trouvée</h1>
        <p>Bienvenue sur notre site ! Voici un index des pages et leurs fonctions :</p>
        <ul class="list-unstyled">
            <li class="mb-2"><a href="/home" class="text-primary">Accueil</a> - Page d'accueil du site.</li>
            <li class="mb-2"><a href="/about" class="text-primary">À propos de nous</a> - Informations sur notre entreprise.</li>
            <li class="mb-2"><a href="/services" class="text-primary">Services</a> - Description des services que nous offrons.</li>
            <li class="mb-2"><a href="/contact" class="text-primary">Contact</a> - Formulaire pour nous contacter.</li>
            <li class="mb-2"><a href="/faq" class="text-primary">FAQ</a> - Questions fréquentes.</li>
            <li class="mb-2"><a href="/blog" class="text-primary">Blog</a> - Articles et actualités récentes.</li>
        </ul>
    </div>
    <div class="container text-center mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="display-1 text-muted">404</h1>
                        <h2 class="mb-4">Page Non Trouvée</h2>
                        <p class="lead mb-4">La page que vous recherchez n'existe pas ou n'est plus disponible.</p>
                        
                        <?php if (!isset($_SESSION['user'])): ?>
                            <div class="mb-4">
                                <p>Pour accéder à toutes les fonctionnalités :</p>
                                <a href="index.php?page=Login" class="btn btn-primary me-2">Connexion</a>
                                <a href="index.php?page=inscription" class="btn btn-outline-primary">Inscription</a>
                            </div>
                        <?php endif; ?>
                        
                        <a href="index.php?page=accueil" class="btn btn-link">
                            <i class="fas fa-home"></i> Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


</div>