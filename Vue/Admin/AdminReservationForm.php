<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login&error=Vous devez être connecté pour faire une réservation');
    exit;
}

if (!isset($_GET['chambre_id'])) {
    header('Location: index.php?page=chambres&error=Aucune chambre sélectionnée');
    exit;
}

require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Model/ChambresModel.php');
require_once(__DIR__ . '/../../Model/ReservationModel.php');

$chambreModel = new ChambresModel($bdd);
$reservationModel = new ReservationModel($bdd);

$chambre = $chambreModel->getChambreById($_GET['chambre_id']);

if (!$chambre) {
    header('Location: index.php?page=chambres&error=Chambre introuvable');
    exit;
}

if (!$chambre['Statut']) {
    header('Location: index.php?page=chambres&error=Cette chambre n\'est pas disponible');
    exit;
}
?>
<?php include('./vue/header.php'); ?>
<div class="container py-4">
    <h1 class="mb-4">Réserver la Chambre <?= htmlspecialchars($chambre['ID_Chambres']) ?></h1>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="/ppe/Controller/ReservationController.php" method="POST">
                <input type="hidden" name="action" value="createReservation">
                <input type="hidden" name="chambre_id" value="<?= $chambre['ID_Chambres'] ?>">
                <input type="hidden" name="prix_par_nuit" value="<?= $chambre['Prix'] ?>">

                <div class="mb-3">
                    <label for="date_debut" class="form-label">Date d'arrivée</label>
                    <input type="date" class="form-control" id="date_debut" name="date_debut" 
                           min="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="date_fin" class="form-label">Date de départ</label>
                    <input type="date" class="form-control" id="date_fin" name="date_fin" 
                           min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prix par nuit</label>
                    <div class="form-control-plaintext">
                        <?= number_format($chambre['Prix'], 2, ',', ' ') ?> €
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prix total</label>
                    <div id="prix_total" class="form-control-plaintext">
                        -- €
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-calendar-check"></i> Confirmer la réservation
                    </button>
                    <a href="index.php?page=chambres" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Retour aux chambres
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateDebut = document.getElementById('date_debut');
    const dateFin = document.getElementById('date_fin');
    const prixParNuit = <?= $chambre['Prix'] ?>;
    const prixTotalElement = document.getElementById('prix_total');

    function updatePrixTotal() {
        if (dateDebut.value && dateFin.value) {
            const start = new Date(dateDebut.value);
            const end = new Date(dateFin.value);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays > 0) {
                const prixTotal = diffDays * prixParNuit;
                prixTotalElement.textContent = new Intl.NumberFormat('fr-FR', {
                    style: 'currency',
                    currency: 'EUR'
                }).format(prixTotal);
            } else {
                prixTotalElement.textContent = '-- €';
            }
        }
    }

    dateDebut.addEventListener('change', function() {
        // Update min date of date_fin
        const nextDay = new Date(dateDebut.value);
        nextDay.setDate(nextDay.getDate() + 1);
        dateFin.min = nextDay.toISOString().split('T')[0];
        
        // Clear date_fin if it's before date_debut
        if (dateFin.value && new Date(dateFin.value) <= new Date(dateDebut.value)) {
            dateFin.value = '';
        }
        
        updatePrixTotal();
    });

    dateFin.addEventListener('change', updatePrixTotal);
});
</script>
<?php include '/xampp/htdocs/ppe/Vue/Footer.php';?>
