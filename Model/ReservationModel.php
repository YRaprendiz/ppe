<?php
class UserReservationModel {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function createReservation($userId, $chambreId, $dateDebut, $dateFin, $prixTotal) {
        try {
            $req = $this->bdd->prepare("
                INSERT INTO Reservations (ID_Utilisateur, ID_Chambres, Date_Debut, Date_Fin, Prix, Statut_Reservation)
                VALUES (:user_id, :chambre_id, :date_debut, :date_fin, :prix, 'En attente')
            ");

            return $req->execute([
                ':user_id' => $userId,
                ':chambre_id' => $chambreId,
                ':date_debut' => $dateDebut,
                ':date_fin' => $dateFin,
                ':prix' => $prixTotal
            ]);
        } catch (PDOException $e) {
            error_log("Error creating reservation: " . $e->getMessage());
            return false;
        }
    }

    public function getReservationsByUser($userId) {
        try {
            $req = $this->bdd->prepare("
                SELECT r.*, c.Type_Chambre, c.Prix
                FROM Reservations r
                JOIN Chambres c ON r.ID_Chambres = c.ID_Chambres
                WHERE r.ID_Utilisateur = :user_id
                ORDER BY r.Date_Debut DESC
            ");
            
            $req->execute([':user_id' => $userId]);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting user reservations: " . $e->getMessage());
            return [];
        }
    }

    public function getReservationById($id) {
        try {
            $req = $this->bdd->prepare("
                SELECT r.*, c.Type_Chambre, c.Prix
                FROM Reservations r
                JOIN Chambres c ON r.ID_Chambres = c.ID_Chambres
                WHERE r.ID_Reservation = :id
            ");
            
            $req->execute([':id' => $id]);
            return $req->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting reservation: " . $e->getMessage());
            return null;
        }
    }

    public function cancelReservation($id, $userId) {
        try {
            // First check if the reservation belongs to the user
            $req = $this->bdd->prepare("
                SELECT ID_Reservation 
                FROM Reservations 
                WHERE ID_Reservation = :id AND ID_Utilisateur = :user_id
            ");
            $req->execute([':id' => $id, ':user_id' => $userId]);
            
            if (!$req->fetch()) {
                return false; // Reservation not found or doesn't belong to user
            }

            // Update the reservation status to cancelled (0)
            $req = $this->bdd->prepare("
                UPDATE Reservations 
                SET Statut_Reservation = 'Annulée' 
                WHERE ID_Reservation = :id
            ");
            
            return $req->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error cancelling reservation: " . $e->getMessage());
            return false;
        }
    }

    public function checkRoomAvailability($chambreId, $dateDebut, $dateFin) {
        try {
            $req = $this->bdd->prepare("
                SELECT COUNT(*) as count
                FROM Reservations
                WHERE ID_Chambres = :chambre_id
                AND Statut_Reservation IN ('En attente', 'Confirmée')
                AND (
                    (Date_Debut <= :date_fin AND Date_Fin >= :date_debut)
                )
            ");
            
            $req->execute([
                ':chambre_id' => $chambreId,
                ':date_debut' => $dateDebut,
                ':date_fin' => $dateFin
            ]);
            
            $result = $req->fetch(PDO::FETCH_ASSOC);
            return $result['count'] == 0; // Returns true if room is available
        } catch (PDOException $e) {
            error_log("Error checking room availability: " . $e->getMessage());
            return false;
        }
    }

    public function getActiveReservationsForRoom($chambreId) {
        try {
            $req = $this->bdd->prepare("
                SELECT *
                FROM Reservations
                WHERE ID_Chambres = :chambre_id
                AND Statut_Reservation IN ('En attente', 'Confirmée')
                ORDER BY Date_Debut
            ");
            
            $req->execute([':chambre_id' => $chambreId]);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting room reservations: " . $e->getMessage());
            return [];
        }
    }
}
?>
