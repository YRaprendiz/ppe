<?php
session_start();

// Check if this is a direct POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['page'])) {
    // Redirect to index.php with reservations page
    header('Location: /ppe/index.php?page=reservations');
    exit;
}

require_once(__DIR__ . '/../Bdd/bdd.php');
require_once(__DIR__ . '/../Model/ReservationModel.php');
require_once(__DIR__ . '/../Model/ChambresModel.php');

if (!isset($_SESSION['user'])) {
    header('Location: /ppe/index.php?page=login&error=Vous devez être connecté pour effectuer cette action');
    exit;
}

$reservationModel = new ReservationModel($bdd);
$chambreModel = new ChambresModel($bdd);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'createReservation':
            if (!isset($_POST['chambre_id'], $_POST['date_debut'], $_POST['date_fin'], $_POST['prix_par_nuit'])) {
                header('Location: /ppe/index.php?page=chambres&error=Données manquantes');
                exit;
            }

            $chambreId = $_POST['chambre_id'];
            $dateDebut = $_POST['date_debut'];
            $dateFin = $_POST['date_fin'];
            $prixParNuit = floatval($_POST['prix_par_nuit']);

            // Validate dates
            $today = new DateTime();
            $startDate = new DateTime($dateDebut);
            $endDate = new DateTime($dateFin);

            if ($startDate < $today) {
                header("Location: /ppe/index.php?page=reservation&chambre_id=$chambreId&error=La date de début doit être aujourd'hui ou après");
                exit;
            }

            if ($endDate <= $startDate) {
                header("Location: /ppe/index.php?page=reservation&chambre_id=$chambreId&error=La date de fin doit être après la date de début");
                exit;
            }

            // Calculate number of nights and total price
            $interval = $startDate->diff($endDate);
            $numberOfNights = $interval->days;
            $prixTotal = $numberOfNights * $prixParNuit;

            // Check if room is still available
            $chambre = $chambreModel->getChambreById($chambreId);
            if (!$chambre || !$chambre['Statut']) {
                header('Location: /ppe/index.php?page=chambres&error=Cette chambre n\'est plus disponible');
                exit;
            }

            // Check for conflicting reservations
            $activeReservations = $reservationModel->getActiveReservationsForRoom($chambreId);
            foreach ($activeReservations as $reservation) {
                $resStart = new DateTime($reservation['Date_Debut']);
                $resEnd = new DateTime($reservation['Date_Fin']);

                if (
                    ($startDate >= $resStart && $startDate < $resEnd) || // Start date conflicts
                    ($endDate > $resStart && $endDate <= $resEnd) || // End date conflicts
                    ($startDate <= $resStart && $endDate >= $resEnd) // Reservation spans existing reservation
                ) {
                    header("Location: /ppe/index.php?page=reservation&chambre_id=$chambreId&error=La chambre n'est pas disponible pour ces dates");
                    exit;
                }
            }

            // Add detailed error logging
            error_log("Attempting to create reservation:");
            error_log("User ID: " . $_SESSION['user']['ID_Utilisateur']);
            error_log("Chambre ID: " . $chambreId);
            error_log("Date Debut: " . $dateDebut);
            error_log("Date Fin: " . $dateFin);
            error_log("Prix Total: " . $prixTotal);
            error_log("Chambre Status: " . ($chambre['Statut'] ? 'Active' : 'Inactive'));
            
            // Log active reservations for debugging
            error_log("Active Reservations for Room $chambreId:");
            foreach ($activeReservations as $reservation) {
                error_log("Existing Reservation - Start: " . $reservation['Date_Debut'] . ", End: " . $reservation['Date_Fin']);
            }

            // Create the reservation
            if ($reservationModel->createReservation(
                $_SESSION['user']['ID_Utilisateur'],
                $chambreId,
                $dateDebut,
                $dateFin,
                $prixTotal
            )) {
                header('Location: /ppe/index.php?page=reservations&message=Réservation créée avec succès');
            } else {
                header("Location: /ppe/index.php?page=reservation&chambre_id=$chambreId&error=Erreur lors de la création de la réservation");
            }
            break;

        case 'cancelReservation':
            if (!isset($_POST['id'])) {
                header('Location: /ppe/index.php?page=reservations&error=ID de réservation manquant');
                exit;
            }

            $reservationId = $_POST['id'];
            $userId = $_SESSION['user']['ID_Utilisateur'];

            if ($reservationModel->cancelReservation($reservationId, $userId)) {
                header('Location: /ppe/index.php?page=reservations&message=Réservation annulée avec succès');
            } else {
                header('Location: /ppe/index.php?page=reservations&error=Erreur lors de l\'annulation de la réservation');
            }
            break;

        default:
            header('Location: /ppe/index.php?page=chambres&error=Action non valide');
            break;
    }
} else {
    header('Location: /ppe/index.php?page=chambres&error=Méthode non autorisée');
}
