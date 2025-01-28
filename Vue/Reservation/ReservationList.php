<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Model/ReservationModel.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: /ppe/Vue/User/UserLogin.php');
    exit();
}

$reservationModel = new ReservationModel($bdd);
$reservations = $reservationModel->getReservationsByUser($_SESSION['user']['ID_Utilisateur']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mes Réservations - PPE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">Mes Réservations</h1>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($reservations)): ?>
            <div class="row g-4">
                <?php foreach ($reservations as $reservation): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Chambre <?php echo htmlspecialchars($reservation['ID_Chambres']); ?></h5>
                                <span class="badge <?php echo $reservation['Statut'] ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo $reservation['Statut'] ? 'Active' : 'Annulée'; ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <i class="bi bi-calendar-check"></i>
                                        <strong>Arrivée:</strong> 
                                        <?php echo htmlspecialchars(date('d/m/Y', strtotime($reservation['Date_Debut']))); ?>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="bi bi-calendar-x"></i>
                                        <strong>Départ:</strong> 
                                        <?php echo htmlspecialchars(date('d/m/Y', strtotime($reservation['Date_Fin']))); ?>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="bi bi-cash"></i>
                                        <strong>Prix Total:</strong> 
                                        <?php echo number_format($reservation['Prix_Total'], 2, ',', ' '); ?> €
                                    </li>
                                </ul>
                            </div>
                            <?php if ($reservation['Statut']): ?>
                                <div class="card-footer">
                                    <form action="/ppe/Controller/ReservationController.php" method="POST" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                        <input type="hidden" name="action" value="cancelReservation">
                                        <input type="hidden" name="id" value="<?php echo $reservation['ID_Reservation']; ?>">
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="bi bi-x-circle"></i> Annuler la réservation
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-calendar-x display-1 text-muted mb-3"></i>
                <h3 class="text-muted">Vous n'avez aucune réservation</h3>
                <p class="text-muted mb-4">Commencez par réserver une chambre</p>
                <a href="/ppe/index.php" class="btn btn-primary">
                    <i class="bi bi-search"></i> Voir les chambres disponibles
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
