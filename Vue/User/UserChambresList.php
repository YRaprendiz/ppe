<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Model/ChambresModel.php');

$chambreModel = new ChambresModel($bdd);
$chambres = $chambreModel->getAllChambres();
?>

<?php include('/xampp/htdocs/ppe/Vue/Header.php'); ?>
<div class="container py-5">
    <h1 class="mb-4">Liste des Chambres</h1>

    <div class="row g-4">
        <?php foreach ($chambres as $chambre): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <img src="data:image/jpeg;base64,<?= base64_encode($chambre['Images']); ?>" 
                         class="card-img-top" alt="Chambre Image" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">Chambre <?= htmlspecialchars($chambre['ID_Chambres']); ?></h5>
                        <p class="card-text"><?= htmlspecialchars($chambre['Description']); ?></p>
                        <p class="card-text"><strong>Prix:</strong> <?= number_format($chambre['Prix'], 2, ',', ' '); ?> € par nuit</p>
                    </div>
                    <div class="card-footer">
                        <p>Veuillez vous connecter pour voir les détails ou faire une réservation <a href="./index.php?page=authLogin">ici</a></p>
                        
                        <?php if (isset($_SESSION['user'])): ?>
                            <a href="/ppe/Vue/User/UserChambresDetails.php?chambre_id=<?= $chambre['ID_Chambres']; ?>" class="btn btn-primary w-100">
                                <i class="bi bi-info-circle"></i> Voir Détails
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include('/xampp/htdocs/ppe/Vue/Footer.php'); ?>