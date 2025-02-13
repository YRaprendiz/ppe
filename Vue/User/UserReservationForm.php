<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=authLogin&error=Vous devez être connecté pour faire une réservation');
    exit;
}

if (!isset($_GET['chambre_id'])) {
    header('Location: index.php?page=userChambresList&error=Aucune chambre sélectionnée');
    exit;
}

require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Model/ChambresModel.php');
require_once(__DIR__ . '/../../Model/ReservationModel.php');

$chambreModel = new ChambresModel($bdd);
$reservationModel = new ReservationModel($bdd);

$chambre = $chambreModel->getChambreById($_GET['chambre_id']);

if (!$chambre) {
    header('Location: index.php?page=userChambresList&error=Chambre introuvable');
    exit;
}

if (!$chambre['Statut']) {
    header('Location: index.php?page=userChambresList&error=Cette chambre n\'est pas disponible');
    exit;
}
?>
<?php include('/xampp/htdocs/ppe/Vue/Header.php'); ?>
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
                    <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                </div>

                <div class="mb-3">
                    <label for="date_fin" class="form-label">Date de départ</label>
                    <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                </div>

                <div class="mb-3">
                    <label for="prix_total" class="form-label">Prix Total</label>
                    <p id="prix_total">-- €</p>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Réserver</button>
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
            
            // Validate dates client-side
            if (start >= end) {
                alert('La date de départ doit être après la date d\'arrivée');
                dateFin.value = '';
                prixTotalElement.textContent = '-- €';
                return;
            }
            
            const timeDiff = end.getTime() - start.getTime();
            const nights = Math.ceil(timeDiff / (1000 * 3600 * 24)); // Calculate nights
            
            const totalPrice = nights * prixParNuit;
            prixTotalElement.textContent = totalPrice.toLocaleString('fr-FR', {
                minimumFractionDigits: 2, 
                maximumFractionDigits: 2
            }) + ' €';
        }
    }

    dateDebut.addEventListener('change', updatePrixTotal);
    dateFin.addEventListener('change', updatePrixTotal);

    // Prevent form submission if dates are invalid
    document.querySelector('form').addEventListener('submit', function(event) {
        if (!dateDebut.value || !dateFin.value) {
            event.preventDefault();
            alert('Veuillez sélectionner les dates d\'arrivée et de départ');
        }
    });
});
</script>
<?php include('/xampp/htdocs/ppe/Vue/Footer.php'); ?>
