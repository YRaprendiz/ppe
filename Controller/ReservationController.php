<?php
session_start();

require_once(__DIR__ . '/../Bdd/bdd.php');
require_once(__DIR__ . '/../Model/ReservationModel.php');
require_once(__DIR__ . '/../Model/ChambresModel.php');

if (!isset($_SESSION['user'])) {
    header('Location: /ppe/index.php?page=authLogin&error=Vous devez être connecté pour effectuer cette action');
    exit();
}

$reservationModel = new ReservationModel($bdd);
$chambreModel = new ChambresModel($bdd);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'createReservation':
            if (!isset($_POST['chambre_id'], $_POST['date_debut'], $_POST['date_fin'], $_POST['prix_par_nuit'])) {
                header('Location: /ppe/index.php?page=userChambresList&error=Données manquantes');
                exit();
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
                header("Location: /ppe/index.php?page=userChambresList&error=La date de début doit être aujourd'hui ou après");
                exit();
            }

            if ($endDate <= $startDate) {
                header("Location: /ppe/index.php?page=userChambresList&error=La date de fin doit être après la date de début");
                exit();
            }

            // Calculate number of nights and total price
            $interval = $startDate->diff($endDate);
            $numberOfNights = $interval->days;
            $prixTotal = $numberOfNights * $prixParNuit;

            // Check if room is still available
            $chambre = $chambreModel->getChambreById($chambreId);
            if (!$chambre || !$chambre['Statut']) {
                header('Location: /ppe/index.php?page=userChambresList&error=Cette chambre n\'est plus disponible');
                exit();
            }

            // Check for conflicting reservations
            if (!$reservationModel->checkRoomAvailability($chambreId, $dateDebut, $dateFin)) {
                header("Location: /ppe/index.php?page=userChambresList&error=La chambre n'est pas disponible pour ces dates");
                exit();
            }

            // Create the reservation
            if ($reservationModel->createReservation(
                $_SESSION['user']['ID_Utilisateur'],
                $chambreId,
                $dateDebut,
                $dateFin,
                $prixTotal
            )) {
                header('Location: /ppe/index.php?page=userMesReservationList&message=Réservation créée avec succès');
            } else {
                header("Location: /ppe/index.php?page=userChambresList&error=Erreur lors de la création de la réservation");
            }
            break;

        case 'cancelReservation':
            if (!isset($_POST['id'])) {
                header('Location: /ppe/index.php?page=userMesReservationList&error=ID de réservation manquant');
                exit();
            }

            $reservationId = $_POST['id'];
            $userId = $_SESSION['user']['ID_Utilisateur'];

            if ($reservationModel->cancelReservation($reservationId, $userId)) {
                header('Location: /ppe/index.php?page=userMesReservationList&message=Réservation annulée avec succès');
            } else {
                header('Location: /ppe/index.php?page=userMesReservationList&error=Erreur lors de l\'annulation de la réservation');
            }
            break;

        default:
            header('Location: /ppe/index.php?page=userChambresList&error=Action non valide');
            break;
    }
} else {
    header('Location: /ppe/index.php?page=userChambresList&error=Méthode non autorisée');
}
?>
