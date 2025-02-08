<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('./Bdd/bdd.php');
include('./Model/ChambresModel.php');

$ChambresModel = new ChambresModel($bdd);
$chambres = $ChambresModel->getAllChambres();

?>
<?php include('/xampp/htdocs/ppe/Vue/Header.php'); ?>
    <div class="container py-4">
        <h1>Liste des Chambres</h1>
        
        <div class="row g-4">
            <?php foreach ($chambres as $chambre): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <img src="data:image/jpeg;base64,<?= base64_encode($chambre['Images']) ?>" 
                            class="card-img-top" alt="Image Chambre" style="height: 200px; object-fit: cover;">
                        
                        <div class="card-body">
                            <h5 class="card-title">Chambre<?= htmlspecialchars($chambre['ID_Chambres']) ?></h5>
                            <p class="card-text">
                                <span class="badge bg-info"><?= htmlspecialchars($chambre['Type_Chambre']) ?></span>
                            </p>
                            <p class="card-text">
                                <span class="badge <?= $chambre['Statut'] ? 'bg-success' : 'bg-danger' ?>">
                                    <?= $chambre['Statut'] ? 'Disponible' : 'Occupée' ?>
                                </span>
                            </p>
                            <p class="card-text">
                                <strong>Prix:</strong> 
                                <span class="text-primary"><?= number_format($chambre['Prix'], 2, ',', ' ') ?> €</span>
                            </p>
                            <p class="card-text"><?= htmlspecialchars($chambre['Description']) ?></p>
                        </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-flex gap-2">
                                    <a href="index.php?page=chambreForm&id=<?= $chambre['ID_Chambres'] ?>" 
                                    class="btn btn-outline-primary flex-grow-1">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="index.php?page=reservation&chambre_id=<?= $chambre['ID_Chambres'] ?>" 
                                class="btn btn-primary w-100 <?= !$chambre['Statut'] ? 'disabled' : '' ?>">
                                    <i class="bi bi-calendar-check"></i> 
                                    <?= $chambre['Statut'] ? 'Réserver' : 'Non disponible' ?>
                                </a>
                            </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($chambres)): ?>
            <div class="text-center py-5">
                <i class="bi bi-house-x display-1 text-muted mb-3"></i>
                <h3 class="text-muted">Aucune chambre disponible</h3>
                <p class="text-muted">Veuillez réessayer plus tard</p>
            </div>
        <?php endif; ?>
    </div>
<?php include '/xampp/htdocs/ppe/Vue/Footer.php';?>