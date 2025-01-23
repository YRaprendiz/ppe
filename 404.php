<?php
// Ensure this page is included through the main index.php
if (!defined('INCLUDED_FROM_INDEX')) {
    header('Location: /ppe/index.php?page=404');
    exit();
}
?>

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
                            <a href="index.php?page=connexion" class="btn btn-primary me-2">Connexion</a>
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