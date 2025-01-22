<?php

class ChambreModel {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    // Gestion des Chambres
    public function ajouterChambre($image, $chambreNum, $type, $prix, $descriptif) {
        $req = $this->bdd->prepare("INSERT INTO Chambres (Images, Chambre_000, Type_Chambre, Prix, Descriptif) VALUES (:image, :chambreNum, :type, :prix, :descriptif)");
        $req->bindParam(':image', $image, PDO::PARAM_LOB);
        $req->bindParam(':chambreNum', $chambreNum);
        $req->bindParam(':type', $type);
        $req->bindParam(':prix', $prix);
        $req->bindParam(':descriptif', $descriptif);
        return $req->execute();
    }

    public function modifierChambre($id, $type, $prix, $descriptif, $stat) {
        $req = $this->bdd->prepare("UPDATE Chambres SET Type_Chambre = :type, Prix = :prix, Descriptif = :descriptif, Stat = :stat WHERE ID_Chambres = :id");
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->bindParam(':type', $type);
        $req->bindParam(':prix', $prix);
        $req->bindParam(':descriptif', $descriptif);
        $req->bindParam(':stat', $stat);
        return $req->execute();
    }

    public function supprimerChambre($id) {
        $req = $this->bdd->prepare("DELETE FROM Chambres WHERE ID_Chambres = :id");
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        return $req->execute();
    }

    public function getChambres() {
        $req = $this->bdd->prepare("SELECT * FROM Chambres");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    // Gestion des Réservations
    public function reserverChambre($idChambre, $idUtilisateur, $dateCheckIn, $dateCheckOut) {
        $req = $this->bdd->prepare("INSERT INTO Reservations (ID_Chambres, ID_Utilisateur, Date_Reservation, Date_CheckIn, Date_CheckOut) VALUES (:idChambre, :idUtilisateur, NOW(), :dateCheckIn, :dateCheckOut)");
        $req->bindParam(':idChambre', $idChambre, PDO::PARAM_INT);
        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $req->bindParam(':dateCheckIn', $dateCheckIn);
        $req->bindParam(':dateCheckOut', $dateCheckOut);
        return $req->execute();
    }

    public function annulerReservation($idReservation) {
        $req = $this->bdd->prepare("UPDATE Reservations SET Statut = 'Annulée' WHERE ID_Reservation = :idReservation");
        $req->bindParam(':idReservation', $idReservation, PDO::PARAM_INT);
        return $req->execute();
    }

    public function getReservations() {
        $req = $this->bdd->prepare("SELECT * FROM Reservations");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
