<!-- VueAdmin.php-->
<?php
session_start();
include_once('./ModelUser.php');
$utilisateurModel = new ModelUser();

$isAdmin = isset($_SESSION['user_id']) && $utilisateurModel->getRoleById($_SESSION['user_id']) === 'admin';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Accueil</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <?php if ($isAdmin): ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=adminPage">Administration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="VueAdminChambreAjouter.php">addchambre</a>
                </li>
                
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
