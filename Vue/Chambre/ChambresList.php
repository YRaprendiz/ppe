<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('./Bdd/bdd.php');
include('./Model/ChambresModel.php');

$ChambresModel = new ChambresModel($bdd);
$chambres = $ChambresModel->getAllChambres();

// Define user role
$isAdmin = isset($_SESSION['user']) && isset($_SESSION['user']['User_role']) && $_SESSION['user']['User_role'] === 'admin';
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Liste des Chambres</h1>
        <?php if ($isAdmin): ?>
            <a href="index.php?page=chambreForm" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Ajouter une chambre
            </a>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php foreach ($chambres as $chambre): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <img src="data:image/jpeg;base64,<?= base64_encode($chambre['Images']) ?>" 
                         class="card-img-top"
                         alt="Image Chambre"
                         style="height: 200px; object-fit: cover;">
                    
                    <div class="card-body">
                        <h5 class="card-title">Chambre <?= htmlspecialchars($chambre['ID_Chambres']) ?></h5>
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

                    <?php if ($isAdmin): ?>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex gap-2">
                                <a href="index.php?page=chambreForm&id=<?= $chambre['ID_Chambres'] ?>" 
                                   class="btn btn-outline-primary flex-grow-1">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                                <form action="Controller/ChambresController.php" 
                                      method="POST" 
                                      class="flex-grow-1"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette chambre ?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $chambre['ID_Chambres'] ?>">
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="card-footer bg-transparent">
                            <a href="index.php?page=reservation&chambre_id=<?= $chambre['ID_Chambres'] ?>" 
                               class="btn btn-primary w-100 <?= !$chambre['Statut'] ? 'disabled' : '' ?>">
                                <i class="bi bi-calendar-check"></i> 
                                <?= $chambre['Statut'] ? 'Réserver' : 'Non disponible' ?>
                            </a>
                        </div>
                    <?php endif; ?>
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